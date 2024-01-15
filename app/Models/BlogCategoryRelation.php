<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class BlogCategoryRelation extends Model
{
    use HasFactory, Searchable;
    protected $table = 'blog_categries_relation';
    protected  $fillable = [
        'name',
        'desc',
    ];
}


