<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelReservationRoomPeople extends Model
{
    use HasFactory;

    public function hotel_reservation_room(){
        return $this->belongsTo(HotelReservationRoom::class);
    }
}
