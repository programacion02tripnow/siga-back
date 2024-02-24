<?php

namespace App\Models;

use App\Strategies\CarRentalReservationStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarRentalReservation extends Model
{
    use HasFactory;

    protected $casts = [
        'insurance' => 'boolean',
    ];

    public static $strategy = CarRentalReservationStrategy::class;

    public function reservation_details(){
        return $this->morphMany(ReservationDetail::class, 'reservable');
    }

    public function car_rental_addons(){
        return $this->hasMany(CarRentalAddon::class);
    }

    public function loadRelations(){
        $this->car_rental_addons;
    }
}
