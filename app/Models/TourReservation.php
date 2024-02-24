<?php

namespace App\Models;

use App\Strategies\TourReservationStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourReservation extends Model
{
    use HasFactory;

    public static $strategy = TourReservationStrategy::class;

    public function reservation_details(){
        return $this->morphMany(ReservationDetail::class, 'reservable');
    }

    public function loadRelations(){

    }
}
