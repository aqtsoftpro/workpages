<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected  $fillable = [
        'name',
        'code',
        'status'
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


