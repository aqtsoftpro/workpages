<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class SalaryRange extends Model
{
    use HasFactory, Searchable;

    protected $table = 'salary_range';

    protected $fillable = [
        'start_price','end_price'
    ];
}
