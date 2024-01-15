<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;



class JobPostedOn extends Model
{
    use HasFactory, Searchable;

    protected $table = 'job_posted_no';

    protected $fillable = [
        // 'start_price','end_price'
    ];
}
