<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelReservationRoom extends Model
{
    use HasFactory;

    public function hotel_reservation(){
        return $this->belongsTo(HotelReservation::class);
    }

    public function hotel_reservation_room_people(){
        return $this->hasMany(HotelReservationRoomPeople::class);
    }
}
