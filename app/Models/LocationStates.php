<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationStates extends Model
{
    use HasFactory;

    protected $table = 'location_states';

    protected  $fillable = [
        'name',
        'location_id',
        'status',
    ];

    
    public function location(){
        return $this->belongsTo(Location::class);
    }

}


