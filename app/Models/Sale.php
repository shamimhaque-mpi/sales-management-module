<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id', 'creator_id', 'sale_date', 'total'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sale_date' => 'datetime',
        ];
    }


    /**
     * Get the customer associated with the sale.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the creator (staff/admin) who recorded the sale.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get all sale items linked to this sale.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Get all note attached to this sale (polymorphic).
     *
     * @return MorphOne
     */
    public function note(): MorphOne
    {
        return $this->morphOne(Note::class, 'noteable');
    }

    /**
     * Accessor to format the total amount with currency.
     *
     * @return string
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total, 2) . ' BDT';
    }
}
