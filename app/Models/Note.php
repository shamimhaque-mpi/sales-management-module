<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Note extends Model
{
    protected $fillable = ['body'];
    
    /**
     * Get the parent noteable model (polymorphic relation).
     *
     * This allows the Note model to belong to multiple types of models
     * (e.g., Sale, Customer, Product) using Laravel's morphTo relationship.
     *
     * @return MorphTo
     */
    public function noteable(): MorphTo {
        return $this->morphTo();
    }

    /**
     * Mutator: Automatically capitalize the first letter of the note body.
     *
     * Ensures consistent formatting by applying ucfirst() when setting the 'body' attribute.
     *
     * @param string $value
     * @return void
     */
    public function setBodyAttribute($value): void {
        $this->attributes['body'] = ucfirst($value);
    }
}
