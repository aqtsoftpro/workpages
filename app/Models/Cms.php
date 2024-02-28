<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Cms extends Model
{
    use HasFactory, Searchable;
    protected $table = 'cms_pages';

    protected $fillable = [
        'name', 'icon', 'status', 'desc'
    ];
}
