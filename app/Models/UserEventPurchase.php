<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEventPurchase extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Define the relationship between UserEventPurchase and User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the relationship between UserEventPurchase and UserEvent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function events()
    {
        return $this->belongsTo(UserEvent::class, 'event_id');
    }

    /**
     * Define the relationship between UserEventPurchase and UserEventTicket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tickets()
    {
        return $this->belongsTo(UserEventTicket::class, 'ticket_id');
    }

    /**
     * Define the relationship between UserEventPurchase and UserEventBuyer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buyers()
    {
        return $this->hasOne(UserEventTicketBuyer::class, 'purchaseId');
    }

    /**
     * Check if the purchase is a bulk purchase.
     *
     * @return bool
     */
    public function isBulkPurchase()
    {
        return $this->bulkPurchase === 1;
    }

    /**
     * Calculate the total price for the purchase based on quantity and price.
     *
     * @return float
     */
    public function calculateTotalPrice()
    {
        return $this->quantity * $this->price;
    }

    /**
     * Check if the payment is complete.
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->paymentStatus === 1;
    }

    /**
     * Get the full charge for the purchase, including the processor fee.
     *
     * @return float
     */
    public function getTotalCharge()
    {
        return $this->charge + $this->processorFee;
    }

}
