<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];
}


