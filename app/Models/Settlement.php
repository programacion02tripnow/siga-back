<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $hidden = ['auth_token'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reservation_detail(){
        return $this->belongsTo(ReservationDetail::class);
    }

    public function authorization_user(){
        return $this->belongsTo(User::class, 'authorization_user_id');
    }
}
