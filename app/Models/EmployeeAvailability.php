<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class EmployeeAvailability extends Model
{
    use HasFactory, Searchable;
    protected $table = 'employee_availability';
    protected  $fillable = [
        'name','status'
    ];



}


