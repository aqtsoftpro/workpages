<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Testimonial extends Model
{
    use HasFactory, Searchable;
    protected $table = 'testimonials';

    protected $fillable = [
        'name', 'rating', 'image', 'description', 'designation', 'status'
    ];
}
