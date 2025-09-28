<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{
    Model, SoftDeletes
};

class SaleItem extends Model
{
    use SoftDeletes;

    protected $fillable = ['sale_id', 'product_id', 'quantity', 'price', 'discount'];

    /**
     * Get the sale that this item belongs to.
     *
     * @return BelongsTo
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Get the product associated with this sale item.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
