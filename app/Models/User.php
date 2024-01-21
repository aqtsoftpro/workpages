<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Language;
use App\Models\Location;
use App\Models\Suburb;
use App\Models\Designation;
use App\Models\Qualification;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Laravel\Scout\Searchable;
use App\Notifications\VerifyEmailNotification;



class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Billable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'photo',
        'location_id',
        'suburbs',
        'phone',
        'weblink',
        'current_job_location_id',
        'designation_id',
        'qualification_id',
        'language_id',
        'description',
        'address',
        'suburb_id',
        'status'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function designtion(){
        return $this->belongsTo(Designation::class);
    }

    public function language(){
        return $this->belongsTo(Language::class);
    }

    public function qualification(){
        return $this->belongsTo(Qualification::class);
    }

    public function company(){
        return $this->hasOne(Company::class, 'owner_id');
    }

    public function applications(){
        return $this->hasMany(Application::class);
    }

    public function UserMeta(){
        return $this->hasMany(UserMeta::class);
    }

    public function socials(){
        return $this->hasOne(UserSocial::class);
    }

    public function suburb(){
        return $this->hasOne(Suburb::class);
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();
 
        // Customize the data array...
 
        return $array;
    }

    // public function sendEmailNotification()
    // {
    //     $this->notify((new VerifyEmailNotification));
    // }
}
