<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settings extends Model
{
    protected $fillable = [
        'user_id',
        'dark_mode',
        'language',
        'is_admin',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
