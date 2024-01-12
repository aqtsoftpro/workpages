<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as Spatiepermission;

class Permission extends Spatiepermission
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
