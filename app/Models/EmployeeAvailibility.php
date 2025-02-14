<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class EmployeeAvailibility extends Model
{
    use HasFactory, Searchable;
    protected $table = 'employee_availibility';
    protected  $fillable = [
        'name','status'
    ];



}


