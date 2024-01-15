<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class UserMeta extends Model
{
    use HasFactory, Searchable;

    protected $table = 'user_meta';

    protected $fillable = [
        'jobs_applications_email_alert'
    ];
}
