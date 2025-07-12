<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'status',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_VALIDATED = 'validated';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the customer that owns the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Calculate the total amount of the order.
     */
    public function calculateTotal(): float
    {
        return $this->orderItems->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }

    /**
     * Validate the order and decrease stock.
     */
    public function validate(): bool
    {
        if ($this->status !== self::STATUS_PENDING) {
            return false;
        }

        // Check if all products have sufficient stock
        foreach ($this->orderItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return false;
            }
        }

        // Decrease stock for all products
        foreach ($this->orderItems as $item) {
            $item->product->decreaseStock($item->quantity);
        }

        $this->status = self::STATUS_VALIDATED;
        $this->total_amount = $this->calculateTotal();
        
        return $this->save();
    }

    /**
     * Mark order as delivered.
     */
    public function markAsDelivered(): bool
    {
        if ($this->status === self::STATUS_VALIDATED) {
            $this->status = self::STATUS_DELIVERED;
            return $this->save();
        }
        return false;
    }
} 