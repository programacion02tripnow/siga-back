<?php

namespace App\Strategies;

use App\Models\FlightReservation;
use App\Models\FlightReservationFlight;
use App\Models\FlightReservationFlightAdditionalService;
use App\Models\FlightReservationFlightAddon;
use App\Models\FlightReservationPeople;

class FlightReservationStrategy implements ReservationDetailStrategy
{

    public function execute($reservation_detail){
        $params = $reservation_detail['reservable'];
        $flight_reservation = new FlightReservation();
        $flight_reservation->airline = $params['airline'];
        $flight_reservation->PNR = $params['PNR'];
        $flight_reservation->round = false; //$params['round'];
        $flight_reservation->adults_quantity = $params['adults_quantity'];
        $flight_reservation->minors_quantity = $params['minors_quantity'];
        $flight_reservation->migration_text = $params['migration_text'];
        $flight_reservation->general_notes = $params['general_notes'];
        $flight_reservation->international_flight_text = $params['international_flight_text'];
        $flight_reservation->national_flight_text = $params['national_flight_text'];
        $flight_reservation->is_pack = $params['is_pack'];
        $flight_reservation->save();

        foreach($params['flight_reservation_people'] as $person){
            $flight_people = new FlightReservationPeople();
            $flight_people->flight_reservation_id = $flight_reservation->id;
            $flight_people->full_name = $person['full_name'];
            $flight_people->age = $person['age'];
            $flight_people->save();
        }
        foreach($params['flight_reservation_flights'] as $flight){
            $flight_flight = new FlightReservationFlight();
            $flight_flight->flight_reservation_id = $flight_reservation->id;
            $flight_flight->type = $flight['type'];
            $flight_flight->flight_number = $flight['flight_number'];
            $flight_flight->departure_city = $flight['departure_airport'];
            $flight_flight->departure_airport = $flight['departure_airport'];
            $flight_flight->departure_datetime = date('Y-m-d H:i:s', strtotime($flight['departure_datetime']));
            $flight_flight->arrive_city = $flight['arrive_airport'];
            $flight_flight->arrive_airport = $flight['arrive_airport'];
            $flight_flight->arrive_datetime = date('Y-m-d H:i:s', strtotime($flight['arrive_datetime']));
            $flight_flight->public_price = $flight['public_price'];
            $flight_flight->net_price = $flight['net_price'];
            $flight_flight->save();

            foreach($flight['flight_reservation_flight_addons'] as $addon){
                $flight_addon = new FlightReservationFlightAddon();
                $flight_addon->flight_reservation_flight_id = $flight_flight->id;
                $flight_addon->name = $addon['name'];
                $flight_addon->quantity = $addon['quantity'];
                $flight_addon->public_price = $addon['public_price'];
                $flight_addon->net_price = $addon['net_price'];
                $flight_addon->save();
            }
            foreach($flight['flight_reservation_flight_additional_services'] as $additional_service){
                $flight_additional_service = new FlightReservationFlightAdditionalService();
                $flight_additional_service->flight_reservation_flight_id = $flight_flight->id;
                $flight_additional_service->name = $additional_service['name'];
                $flight_additional_service->save();
            }
        }



        return $flight_reservation;
    }
}
