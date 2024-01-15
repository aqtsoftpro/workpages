<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Currency extends Model
{
    use HasFactory, Searchable;
    protected $fillable = [
        'name',
        'short_name',
        'symbol'
    ];
}
