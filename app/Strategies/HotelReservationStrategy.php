<?php

namespace App\Strategies;

use App\Models\HotelReservation;
use App\Models\HotelReservationRoom;
use App\Models\HotelReservationRoomPeople;

class HotelReservationStrategy implements ReservationDetailStrategy
{
public function execute($reservation_detail){
    $params = $reservation_detail['reservable'];
    $hotel_reservation = new HotelReservation();
    $hotel_reservation->destination = $params['destination'];
    $hotel_reservation->hotel_name = $params['hotel_name'];
    $hotel_reservation->hotel_phone = $params['hotel_phone'];
    $hotel_reservation->resort_rate = $params['resort_rate'];
    $hotel_reservation->sanitation_rate = $params['sanitation_rate'];
    $hotel_reservation->check_in = $params['check_in'];
    $hotel_reservation->check_out = $params['check_out'];
    //$hotel_reservation->adults_quantity = $params['adults_quantity'];
    //$hotel_reservation->minors_quantity = $params['minors_quantity'];
    $hotel_reservation->meal_plan = $params['meal_plan'];
    $hotel_reservation->is_pack = $params['is_pack'];
    $hotel_reservation->save();

    foreach($params['hotel_reservation_rooms'] as $room){
        $hotel_room = new HotelReservationRoom();
        $hotel_room->hotel_reservation_id = $hotel_reservation->id;
        $hotel_room->room_type = $room['room_type'];
        $hotel_room->public_price = $room['public_price'];
        $hotel_room->net_price = $room['net_price'];
        $hotel_room->special_request = $room['special_request'];
        $hotel_room->adults_quantity = $room['adults_quantity'] ?? 0;
        $hotel_room->minors_quantity = $room['minors_quantity'] ?? 0;
        $hotel_room->save();

        foreach($room['hotel_reservation_room_people'] as $people){
            $room_people = new HotelReservationRoomPeople();
            $room_people->hotel_reservation_room_id = $hotel_room->id;
            // $room_people->full_name = $people['full_name'];
            $room_people->age = is_array($people) ? $people['age'] : $people;
            $room_people->save();
        }
    }

    return $hotel_reservation;
}
}
