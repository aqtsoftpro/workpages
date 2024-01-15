<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory, Searchable;
    protected $table = 'email_templates';
    protected  $fillable = [
        'email_type', 'name', 'slug', 'desc', 'tags'
    ];
}


