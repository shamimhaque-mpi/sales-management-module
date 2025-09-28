<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['body'];

    public function noteable() {
        return $this->morphTo();
    }

    public function setBodyAttribute($value) {
        $this->attributes['body'] = ucfirst($value);
    }
}
