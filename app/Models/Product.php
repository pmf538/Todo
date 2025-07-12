<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'image_url',
        'stock_alert_threshold',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'stock_alert_threshold' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Check if stock is low.
     */
    public function isStockLow(): bool
    {
        return $this->stock <= $this->stock_alert_threshold;
    }

    /**
     * Decrease stock by quantity.
     */
    public function decreaseStock(int $quantity): bool
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            return $this->save();
        }
        return false;
    }
} 