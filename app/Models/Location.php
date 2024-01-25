<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected  $fillable = [
        'name',
        'code',
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function jobSeeker(): HasMany
    {
        return $this->hasMany(User::class);
    }

}


