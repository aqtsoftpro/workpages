<?php

namespace App\Models;

use App\Models\Job;
use App\Models\User;
use App\Models\Company;
use App\Models\JobApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Application extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'company_id',
        'status_id',
        'job_id',
        'cv',
        'experience',
        'salary'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);

    }

    public function job(){
        return $this->belongsTo(Job::class);
    }

    public function status(){
        return $this->belongsTo(JobApplicationStatus::class);
    }


    public function toSearchableArray(): array
    {
        $array = $this->toArray();
 
        // Customize the data array...
 
        return $array;
    }

}
