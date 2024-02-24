<?php

namespace App\Exports;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReservationsExport implements FromCollection {
    protected $result;
    public function __construct($reservations)
    {

        /*$reservations = Reservation::with('user', 'edited_by', 'customer', 'reservation_details');

        if($request->filled('start_date') && $request->filled('end_date')){

            $reservations->whereBetween('created_at',[date('Y-m-d', strtotime($request->input('start_date'))), date('Y-m-d', strtotime($request->input('end_date')))]);
        }

        $reservations = $reservations->get();

        */

        $excel_array = [
            [
                'BOOKING ID',
                'AGENTE CREADOR',
                'AGENTE EDITOR',
                'CLIENTE',
                'CORREO DEL CLIENTE',
                'CANTIDAD DE SERVICIOS',
                'TIPOS DE SERVICIOS',
                'ESTADO',
                'PRECIO PÚBLICO',
                'PRECIO NETO'
            ]
        ];

        foreach ($reservations as $r) {
            $status = "";
            switch ($r->status){
                case 0:
                    $status = "CANCELADO";
                    break;
                case 1:
                    $status = "PENDIENTE DE PAGO";
                    break;
                case 2:
                    $status = "PAGADO";
                    break;
            }

            $services = "";

            foreach($r->reservation_details as $detail){
                if ($services !== "") {
                    $services .= ", ";
                }
                switch ($detail->reservable_type){
                    case "App\\Models\\HotelReservation":
                        $services .= "HOSPEDAJE";
                        break;
                    case "App\\Models\\TourReservation":
                        $services .= "TOUR";
                        break;
                    case "App\\Models\\FlightReservation":
                        $services .= "VUELO";
                        break;
                    case "App\\Models\\CarRentalReservation":
                        $services .= "VEHÍCULO";
                        break;
                    case "App\\Models\\PickupReservation":
                        $services .= "PICKUP";
                        break;
                }
            }
            $excel_array[] = [
                //BOOKING ID
                $r->booking_id,
                //AGENTE CREADOR
                $r->user->first_name . " " . $r->user->last_name,
                //AGENTE EDITOR
                $r->edited_by ? $r->edited_by->first_name . " " . $r->edited_by->last_name : '',
                //CLIENTE
                $r->customer->first_name . " " . $r->customer->last_name,
                //CORREO DEL CLIENTE
                $r->customer->email,
                //CANTIDAD DE SERVICIOS
                count($r->reservation_details),
                //TIPOS DE SERVICIOS
                $services,
                //ESTAD0
                $status,
                // precio público
                $r->public_price,
                // precio neto
                $r->net_price
            ];
        }

        $this->result = $excel_array;
    }

    public function collection()
    {
        return new Collection($this->result);
    }
}
