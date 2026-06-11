<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['product_id', 'name', 'sku', 'price', 'sale_price', 'stock_quantity', 'attributes', 'is_default'])]
class ProductVariant extends Model
{
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'attributes' => 'array',
            'is_default' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getCurrentPriceAttribute(): string
    {
        return $this->sale_price ?? $this->price;
    }
}
