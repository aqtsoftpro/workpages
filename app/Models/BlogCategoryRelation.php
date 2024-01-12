<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoryRelation extends Model
{
    use HasFactory;
    protected $table = 'blog_categries_relation';
    protected  $fillable = [
        'name',
        'desc',
    ];
}


