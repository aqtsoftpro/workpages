<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory, Searchable;
    protected $table = 'job_categories';

    protected $fillable = [
        'name', 'icon', 'image', 'slug', 'status'
    ];


    



}
