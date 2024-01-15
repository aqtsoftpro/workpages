<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Laravel\Scout\Searchable;


class CompanyReview extends Model
{
    use HasFactory, Searchable;

    protected $table = 'company_review';
    protected $fillable = [
        'name',
        'company_id',
        'user_id',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
