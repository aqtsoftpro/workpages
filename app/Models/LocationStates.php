<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class LocationStates extends Model
{
    use HasFactory, Searchable;

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


