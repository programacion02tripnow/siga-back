<?php

namespace App\Models;

use App\Strategies\HotelReservationStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelReservation extends Model
{
    use HasFactory;
    protected $casts = [
        'is_pack' => 'boolean',
        'hotel_phone' => 'string'
    ];

    public static $strategy = HotelReservationStrategy::class;

    public function reservation_details(){
        return $this->morphMany(ReservationDetail::class, 'reservable');
    }

    public function hotel_reservation_rooms(){
        return $this->hasMany(HotelReservationRoom::class);
    }

    public function loadRelations(){
        $this->hotel_reservation_rooms = $this->hotel_reservation_rooms()->with(['hotel_reservation_room_people'])->get();
    }
}
