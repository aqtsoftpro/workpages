<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class JobApplicationStatus extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
    ];

    protected $table = 'job_application_statuses';
}
