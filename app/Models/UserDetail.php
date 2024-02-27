<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'active_job', 'country_id', 'profile_status', 'is_available', 'intro_video'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
