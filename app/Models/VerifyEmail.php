<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'email', 'token', 'expired_at'
    ];
}
