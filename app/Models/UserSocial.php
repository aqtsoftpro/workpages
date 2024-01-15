<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class UserSocial extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'facebook',
        'twitter',
        'linkedin',
        'pinterest',
        'dribbble',
        'behance'
    ];

}
