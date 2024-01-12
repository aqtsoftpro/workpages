<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;



    protected $fillable = [
        'name', 'slug', 'guard_name', 'permission_category_id'
    ];


    public function permissionCategory()
    {
        return $this->belongsTo(PermissionsCategories::class, 'permission_category_id', 'id');
    }

    

}
