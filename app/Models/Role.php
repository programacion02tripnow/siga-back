<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public static $permissions = [
        'view' => 'VIEW_ROLE',
        'create' => 'CREATE_ROLE',
        'edit' => 'EDIT_ROLE',
        'delete' => 'DELETE_ROLE',
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function role_permissions(){
        return $this->hasMany(RolePermission::class);
    }
}
