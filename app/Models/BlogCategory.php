<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class BlogCategory extends Model
{
    use HasFactory, Searchable;
    protected $table = 'blog_categries';
    protected  $fillable = [
        'name',
        'desc',
    ];

    public function toSearchableArray(): array
    {
        $array = $this->toArray();
 
        // Customize the data array...
 
        return $array;
    }
}


