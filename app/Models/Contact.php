<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'gender',
        'profile_image',
        'additional_file',
        'is_merged',
        'merged_into',
    ];

    /**
     * Contact belongs to a User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Contact has many custom field values
     */
    public function customValues(): HasMany
    {
        return $this->hasMany(ContactCustomFieldValue::class);
    }

    /**
     * Contact may be merged into another contact (master)
     */
    public function mergedIntoContact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'merged_into');
    }
}
