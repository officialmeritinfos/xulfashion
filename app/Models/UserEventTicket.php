<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEventTicket extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    /**
     * Define the relationship between UserEventTicket and UserEvent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function events()
    {
        return $this->belongsTo(UserEvent::class, 'event_id');
    }

    /**
     * Check if the ticket is free.
     *
     * @return bool
     */
    public function isFree()
    {
        return $this->isFree === 1;
    }

    /**
     * Check if the ticket is invite-only.
     *
     * @return bool
     */
    public function isInviteOnly()
    {
        return $this->inviteOnly === 1;
    }

    /**
     * Check if the ticket has unlimited stock.
     *
     * @return bool
     */
    public function hasUnlimitedStock()
    {
        return $this->unlimited === 1;
    }
    /**
     * Check if bulk purchase is allowed.
     *
     * @return bool
     */
    public function allowsBulkPurchase()
    {
        return $this->allowBulkPurchase === 1;
    }
    /**
     * Check if bulk purchase is allowed.
     *
     * @return bool
     */
    public function price()
    {
        // Free ticket
        if ($this->isFree()) {
            return 0;
        }

        return $this->price;
    }

    /**
     * Check if the ticket type is a group.
     *
     * @return bool
     */
    public function isGroupTicket()
    {
        return $this->ticketType === 'group';
    }

    /**
     * Calculate the total price for a given quantity, considering bulk pricing.
     *
     * @param int $quantity
     * @return float
     */
    public function calculatePrice($quantity)
    {
        // Free ticket
        if ($this->isFree()) {
            return 0;
        }

        // Bulk pricing logic
        if ($this->allowsBulkPurchase() && $quantity >= (int) $this->bulkQuantity) {
            return $this->bulkPrice * $quantity;
        }

        // Standard pricing
        return $this->price * $quantity;
    }

    /**
     * Check if the ticket is available for the requested quantity.
     *
     * @param int $quantity
     * @return bool
     */
    public function isAvailable($quantity)
    {
        if ($this->hasUnlimitedStock()) {
            return true;
        }

        return $this->quantity >= $quantity;
    }

    /**
     * Get the group size for group tickets, defaulting to 1 for single tickets.
     *
     * @return int
     */
    public function getGroupSize()
    {
        return $this->isGroupTicket() ? (int) $this->groupSize : 1;
    }

    public function getPerksAttribute($value)
    {
        return $value ? explode(',', $value) : [];
    }


    /**
     * Get the questions associated with the ticket as an array.
     *
     * @return array
     */
    public function getQuestions()
    {
        return $this->questions ? json_decode($this->questions, true) : [];
    }

    public function purchases()
    {
        return $this->hasMany(UserEventPurchase::class, 'ticket_id');
    }
    /**
     * Define the relationship between UserEventTicket and TicketCartItem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ticketCartItems()
    {
        return $this->hasMany(TicketCartItem::class, 'user_event_ticket_id');
    }
}
