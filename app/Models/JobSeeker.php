<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;


class JobSeeker extends Model
{
    use HasFactory, Searchable;
    
    protected $table = 'users';

    protected  $fillable = [
        'name',
        'suburb_id',
        'status',
        'code',
        'email_verified_at'
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);  
    }

}


