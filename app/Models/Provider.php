<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;

    public static $permissions = [
        'view' => 'VIEW_PROVIDER',
        'create' => 'CREATE_PROVIDER',
        'edit' => 'EDIT_PROVIDER',
        'delete' => 'DELETE_PROVIDER',
    ];

    public function reservation_details(){
        return $this->hasMany(ReservationDetail::class);
    }
}
