<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Fiat;
use App\Models\TicketCart;
use App\Models\UserEvent;
use App\Models\UserEventTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EventCartController extends BaseController
{
    protected $cartExpirationDays = 7;

    public function __construct()
    {
        // Middleware to ensure only authenticated users access certain actions
        $this->middleware('auth')->only('mergeGuestCart');
    }

    /**
     * Retrieve or create a cart for the current user or guest.
     *
     * @return TicketCart
     */
    protected function getOrCreateCart($checkGuestOnly=false)
    {
        if (Auth::check() & !$checkGuestOnly) {
            return TicketCart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $guestToken = Cookie::get('guest_token') ?: Str::uuid();
            Cookie::queue('guest_token', $guestToken, $this->cartExpirationDays * 1440);
            return TicketCart::firstOrCreate(['guest_token' => $guestToken]);
        }
    }

    /**
     * Add or update a ticket in the cart.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'user_event_ticket_id' => 'required|exists:user_event_tickets,id',
            'quantity' => 'required|integer|min:0'
        ]);

        try {
            $userEventTicket = UserEventTicket::findOrFail($request->user_event_ticket_id);
            $cart = $this->getOrCreateCart();

            // Check if the cart contains items from a different event
            $existingEventId = $cart->items->first()?->userEventTicket->event_id;

            if ($existingEventId && $existingEventId !== $userEventTicket->event_id) {
                // Clear the cart if it contains items from a different event
                $cart->items()->delete();
            }

            // If quantity is zero, remove the item from the cart
            if ($request->quantity == 0) {
                $cartItem = $cart->items()->where('user_event_ticket_id', $userEventTicket->id)->first();

                if ($cartItem) {
                    $cartItem->delete(); // Remove the item from the cart
                }

                // Recalculate the total cart price after item removal
                $totalPrice = $cart->items->sum(function ($item) {
                    return calculateTotalCostOnTicket($item->user_event_ticket_id) * $item->quantity;
                });

                $event = UserEvent::find($userEventTicket->event_id);

                return response()->json([
                    'success' => true,
                    'cartItem' => null,
                    'totalPrice' => $totalPrice,
                    'message' => 'Item removed from cart.',
                    'currency' => currencySign($event->currency),
                ]);
            }

            // Validate quantity against limits
            if ($request->quantity > $userEventTicket->purchaseLimit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity exceeds purchase limit.',
                    'maxQuantity' => min($userEventTicket->purchaseLimit, $userEventTicket->quantity)
                ], 400);
            }
            if (($request->quantity > $userEventTicket->quantity) && ($userEventTicket->unlimited!=1)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity exceeds available quantity.',
                    'maxQuantity' => min($userEventTicket->purchaseLimit, $userEventTicket->quantity)
                ], 400);
            }

            // Update or add the ticket to the cart with the new quantity
            $cartItem = $cart->items()->updateOrCreate(
                ['user_event_ticket_id' => $userEventTicket->id],
                ['quantity' => $request->quantity]
            );

            $event = UserEvent::find($userEventTicket->event_id);

            // Calculate total cart price
            $totalPrice = $cart->items->sum(function ($item) {
                return calculateTotalCostOnTicket($item->user_event_ticket_id) * $item->quantity;
            });

            return response()->json([
                'success' => true,
                'cartItem' => $cartItem,
                'totalPrice' => $totalPrice,
                'currency' => currencySign($event->currency),
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage() . ' on line ' . $exception->getLine());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: please try again.',
            ], 400);
        }
    }

    /**
     * Display the cart contents.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showCart()
    {
        $cart = $this->getOrCreateCart();
        $totalPrice = $cart->items->sum(function ($item) {
            return $item->userEventTicket->price * $item->quantity;
        });

        return view('mobile.ads.events.checkout.index', compact('cart', 'totalPrice'));
    }

    public function mergeGuestCart()
    {

        $guestToken = Cookie::get('guest_token');
        $guestCart = TicketCart::where([
            'guest_token' =>$guestToken
        ])->whereNot('guest_token',null) ->first();

        logger($guestCart);

        if (!empty($guestCart)) {
            $userCart = $this->getOrCreateCart();
            try {
                DB::transaction(function () use ($guestCart, $userCart) {
                    foreach ($guestCart->items as $item) {
                        $userCartItem = $userCart->items()->where('user_event_ticket_id', $item->user_event_ticket_id)->first();

                        if ($userCartItem) {
                            $userCartItem->quantity += $item->quantity;
                            $userCartItem->save();
                        } else {
                            $userCart->items()->create([
                                'user_event_ticket_id' => $item->user_event_ticket_id,
                                'quantity' => $item->quantity
                            ]);
                        }
                    }

                    // Delete the guest cart after merging
                    $guestCart->delete();
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Cart successfully merged.'
                ]);

            } catch (\Exception $e) {
                logger($e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to merge cart: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'No guest cart found to merge.'
        ]);
    }

    public function deleteCart()
    {
        try {
            $cart = $this->getOrCreateCart();

            if ($cart) {
                $cart->items()->delete();
                $cart->delete();
            }

            return response()->json(['success' => true, 'message' => 'Cart deleted successfully']);
        }catch (\Exception $exception){
            logger($exception->getMessage().' on line '.$exception->getLine());
        }
    }
    public function getCartTotal()
    {
        try {
            $cart = $this->getOrCreateCart();
            // Calculate total price
            $totalPrice = $cart->items->sum(function ($item) {
                return calculateTotalCostOnTicket($item->user_event_ticket_id) * $item->quantity;
            });

            if ($totalPrice >0){
                $ticketId = $cart->items->first()->user_event_ticket_id;
                $ticket = UserEventTicket::where('id', $ticketId)->first();
                $event = UserEvent::where('id',$ticket->event_id)->first();
                $currency = Fiat::where('code', $event->currency)->first();
                $currencySign = currencySign($currency->code);
            }else{
                $currencySign = null;
            }
            return response()->json([
                'totalPrice' => $totalPrice,
                'currency' => $currencySign
            ]);
        }catch (\Exception $exception){
            logger($exception->getMessage().' on line '.$exception->getLine());
        }
    }
    public function renderCartList(Request $request)
    {
        if (!$request->has('ref')){
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 404);
        }

        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('userEventTicket.events')->get();

        $event = UserEvent::where('reference', $request->ref)->first();

        // Calculate subtotal
        $subTotal = $cartItems->sum(function ($item) {
            return calculateTotalCostOnTicket($item->user_event_ticket_id) * $item->quantity;
        });

        $grandTotal = $subTotal;

        // Get currency from the first item’s event (assuming all items in cart are from the same event)
        $currency =$event->currency;

        $cartComponent = view('mobile.ads.events.components.ticket_cart_list', [
            'cartItems' => $cartItems,
            'subTotal' => number_format($subTotal, 2),
            'grandTotal' => number_format($grandTotal, 2),
            'currency' => currencySign($currency),
            'event'=>$event
        ])->render();

        return response()->json(['cartComponent' => $cartComponent]);
    }

}
