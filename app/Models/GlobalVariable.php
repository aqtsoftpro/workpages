<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalVariable extends Model
{
    use HasFactory;

    protected $fillable = [
        'privacy_policy',
        'terms_conditions',
        'phone_line'
    ];
}
