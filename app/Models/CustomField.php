<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomField extends Model
{
    protected $fillable = [
        'name',
        'type', // optional: e.g. text, date, number, etc.
    ];

    /**
     * A CustomField can have many values (for different contacts)
     */
    public function values(): HasMany
    {
        return $this->hasMany(ContactCustomFieldValue::class);
    }
}
