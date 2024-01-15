<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;



class GlobalVariable extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'privacy_policy',
        'terms_conditions',
        'phone_line'
    ];
}
