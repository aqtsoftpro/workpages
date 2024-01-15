<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class EmailTemplate extends Model
{
    use HasFactory, Searchable;
    protected $table = 'email_templates';
    protected  $fillable = [
        'email_type', 'name', 'slug', 'desc', 'tags'
    ];
}


