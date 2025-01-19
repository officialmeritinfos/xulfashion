<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCoupon;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreOrder;
use App\Models\UserStoreOrderBreakdown;
use App\Models\UserStoreSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMerchantOrderPurchase extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public mixed $mailData,$title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData,$title)
    {
        $this->mailData = $mailData;
        $this->title = $title;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->mailData['fromMail'],$this->mailData['siteName']),
            replyTo:[
                $this->mailData['supportMail']
            ] ,
            subject: $this->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $web = GeneralSetting::find(1);
        //let us process email verification link
        $orderRef = $this->mailData['order'];
        $order = UserStoreOrder::where(['reference'=>$orderRef])->firstOrFail();
        $store = UserStore::where('id',$order->store)->first();
        $breakDown = UserStoreOrderBreakdown::where('orderId',$order->id)->get();
        $storeSettings = UserStoreSetting::where('store',$store->id)->first();


        return new Content(
            view: 'emails.send_merchant_order_purchase',
            with: [
                'store'=>$store,
                'order'=>$order,
                'items'=>$breakDown,
                'settings'=>$storeSettings,
                'title'=>$this->title,
                'customer'=>UserStoreCustomer::where('id',$order->customer)->first(),
                'showButton'=>2,
                'coupon' =>UserStoreCoupon::where('id',$order->coupon)->first(),
                'siteName'=>$web->name,
                'web'=>$web,
                'viewMailButton'=>1,
                'subdomain'=>$store->slug
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
