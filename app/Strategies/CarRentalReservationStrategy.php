<?php

namespace App\Strategies;

use App\Models\CarRentalAddon;
use App\Models\CarRentalReservation;

class CarRentalReservationStrategy implements ReservationDetailStrategy
{

    public function execute($reservation_detail){
        $car_reservation = $reservation_detail['reservable'];
        $car_rental_reservation = new CarRentalReservation();
        $car_rental_reservation->pickup = $car_reservation['pickup'];
        $car_rental_reservation->datetime_pickup =  date('Y-m-d H:i:s', strtotime($car_reservation['datetime_pickup']));
        $car_rental_reservation->return_datetime =  date('Y-m-d H:i:s', strtotime($car_reservation['return_datetime']));
        $car_rental_reservation->return = $car_reservation['return'];
        $car_rental_reservation->agency_name = $car_reservation['agency_name'];
        $car_rental_reservation->car_category = $car_reservation['car_category'];
        $car_rental_reservation->insurance = $car_reservation['insurance'];
        $car_rental_reservation->recommendations = $car_reservation['recommendations'];
        $car_rental_reservation->save();

        foreach ($car_reservation['car_rental_addons'] as $addon){
            $car_rental_addon = new CarRentalAddon();
            $car_rental_addon->car_rental_reservation_id = $car_rental_reservation->id;
            $car_rental_addon->name = $addon['name'];
            $car_rental_addon->public_price = $addon['public_price'];
            $car_rental_addon->net_price = $addon['net_price'];
            $car_rental_addon->save();
        }

        return $car_rental_reservation;
    }
}
