<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Company extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'location_id',
        'logo',
        'address',
        'owner_id',
        'package_id',
        'company_type_id',
        'company_size',
        'weblink',
        'cover_photo',
        'facebook',
        'twitter',
        'linkedin',
        'pinterest',
        'dribble',
        'behance',
        'suburb_id',
        'comapny_verified_at',
        'status'
    ];

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function state(){
        return $this->belongsTo(LocationStates::class);
    }

    public function package(){
        return $this->belongsTo(Package::class);
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function jobs(){

        return  $this->hasMany(Job::class);
    }

    public function reviews(){

        return  $this->hasMany(CompanyReview::class);
    }

    public function company_type(){

        return $this->belongsTo(CompanyType::class);
    }

    public function applications(){
        return $this->hasMany(Application::class, 'company_id');
    }
}
