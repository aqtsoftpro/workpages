<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use App\Models\Job;


class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
      'type',
      'name',
      'package_id',
      'company',
      'package',
      'job_title',
      'company_id',
      'job_key',
      'job_slug',
      'location_id',
      'state_id',
      'job_description',
      'job_responsibilities',
      'salary_from',
      'salary_to',
      'currency_id',
      'category_id',
      'Job Title',
      'expiration',
      'job_type_id',
      'vacancy',
      'experience',
      'gender',
      'qualification_id',
      'working_mode',
      'payment_mode',
      'job_id'
    ];

    public function mainCompany(){
      return $this->belongsTo(Company::class);
    }

    public function location(){
      return $this->belongsTo(Location::class);
    }

    public function category(){
      return $this->belongsTo(Category::class);
    }

    public function currency(){
      return $this->belongsTo(Currency::class);
    }

    public function job_type(){
        return $this->belongsTo(JobType::class);
    }

    public function qualification(){
        return $this->belongsTo(Qualification::class);
    }

    public function applications(){
        return $this->hasMany(Application::class);
    }

    public function job(): BelongsTo
    {
      return $this->belongsTo(Job::class);
    }
}


