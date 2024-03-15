<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Language;
use App\Models\Location;
use App\Models\Suburb;
use App\Models\Designation;
use App\Models\{Qualification, UserReview, Document, UserDetail, Subscription};
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Laravel\Scout\Searchable;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Billable, Searchable, SoftDeletes;

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
        'status',
        'email_verified_at',
        'gender'
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

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function job_location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'current_job_location_id');
    }

    public function designtion(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function qualification(){
        return $this->belongsTo(Qualification::class);
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'owner_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function UserMeta(): HasMany
    {
        return $this->hasMany(UserMeta::class);
    }

    public function socials():HasOne
    {
        return $this->hasOne(UserSocial::class);
    }

    public function suburb(): HasOne
    {
        return $this->hasOne(Suburb::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function user_detail(): HasOne
    {
        return $this->hasOne(UserDetail::class);
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

    public function portfolios(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(UserReview::class);
    }

    public function subAccesses(): HasMany
    {
        return $this->hasMany(SubAccess::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
