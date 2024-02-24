<?php

namespace App\Models;

use App\Strategies\CarRentalReservationStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarRentalAddon extends Model
{
    use HasFactory;

    public function car_rental_reservation(){
        return $this->belongsTo(CarRentalReservation::class);
    }
}
