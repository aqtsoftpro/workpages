<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class RoleHasPermission extends Model
{
    use HasFactory, Searchable;

    protected  $fillable= [
        'permission_id',
        'role_id',
    ];

    // public function permissions()
    // {
    //     return $this->hasMany(Permission::class, 'id', 'permission_category_id');
    // }
}
