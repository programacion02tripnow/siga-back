<?php

namespace App\Models;

use App\Strategies\PickupReservationStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupReservation extends Model
{
    use HasFactory;

    public static $strategy = PickupReservationStrategy::class;

    public function reservation_details(){
        return $this->morphMany(ReservationDetail::class, 'reservable');
    }

    public function loadRelations(){
    }
}
