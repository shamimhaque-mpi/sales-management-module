<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\{
    Model, SoftDeletes
};

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'description',
    ];


    // Relationships

    /**
     * Get all sale items that include this product.
     *
     * @return HasMany
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Get all notes attached to this product (polymorphic).
     *
     * @return MorphMany
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'noteable');
    }


    // Accessors

    /**
     * Get the formatted price with currency.
     *
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2) . ' BDT';
    }


    // Mutators

    /**
     * Automatically format product name on save.
     *
     * @param string $value
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    /**
     * Automatically format product description on save.
     *
     * @param string $value
     */
    public function setDescriptionAttribute(string $value): void
    {
        $this->attributes['description'] = ucfirst($value);
    }
}
