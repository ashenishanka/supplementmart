<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'user_id', 'order_number', 'status', 'payment_method', 'payment_status',
    'subtotal', 'shipping_fee', 'total', 'currency', 'shipping_address',
    'customer_name', 'customer_email', 'customer_phone', 'notes',
])]
class Order extends Model
{
    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'shipping_fee' => 'decimal:2',
            'total' => 'decimal:2',
            'shipping_address' => 'array',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<OrderItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'SF-'.now()->format('ymd').'-'.strtoupper(Str::random(4));
        } while (static::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
