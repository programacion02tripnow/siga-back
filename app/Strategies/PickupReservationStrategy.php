<?php

namespace App\Strategies;

use App\Models\PickupReservation;

class PickupReservationStrategy implements ReservationDetailStrategy
{

    public function execute($reservation_detail){
        $params=$reservation_detail['reservable'];
        $pickup_reservation = new PickupReservation();
        $pickup_reservation->destination = $params['destination'];
        $pickup_reservation->pickup = $params['pickup'];
        $pickup_reservation->pickup_comment = $params['pickup_comment'];
        $pickup_reservation->datetime = date('Y-m-d H:i:s', strtotime($params['datetime']));
        $pickup_reservation->adults_quantity = $params['adults_quantity'] ?? 0;
        $pickup_reservation->minors_quantity = $params['minors_quantity'] ?? 0;
        $pickup_reservation->type = $params['type'];
        $pickup_reservation->transportation_type = $params['transportation_type'];
        $pickup_reservation->provider_notes = $params['provider_notes'];
        $pickup_reservation->save();

        return $pickup_reservation;
    }
}
