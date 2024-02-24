<?php

namespace App\Exports;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserCommissionsReport implements FromCollection {
    protected $result;
    public function __construct(Request $request)
    {
        $user = User::with(['reservation_details' => function($q) use ($request) {
            $q->whereNull('cancelled_at')
                ->when($request->filled('start_date') && $request->filled('end_date'), function($q) use ($request) {
                    $q->whereBetween('created_at',[date('Y-m-d', strtotime($request->input('start_date'))), date('Y-m-d', strtotime($request->input('end_date')))]);
                });
        }])->find($request->input('user_id'));

        $excel_array = [
            [
                "ID DE RESERVA",
                "NOMBRE DE PROVEEDOR",
                "NÚMERO DE CONFIRMACIÓN DEL PROVEEDOR",
                "TIPO DE SERVICIO",
                "PRECIO PÚBLICO",
                "PRECIO NETO",
                "COMISIÓN",
            ]
        ];

        foreach ($user->reservation_details as $detail) {
            $service = "";
            switch ($detail->reservable_type){
                case "App\\Models\\HotelReservation":
                    $service = "HOTEL";
                    break;
                case "App\\Models\\TourReservation":
                    $service = "TOUR";
                    break;
                case "App\\Models\\FlightReservation":
                    $service = "VUELO";
                    break;
                case "App\\Models\\CarRentalReservation":
                    $service = "RENTA DE VEHÍCULO";
                    break;
                case "App\\Models\\PickupReservation":
                    $service = "PICKUP";
                    break;
            }
            $excel_array[] = [
                //ID DE RESERVA
                $detail->reservation_id,
                //NOMBRE DE PROVEEDOR
                $detail->provider->name,
                //NÚMERO DE CONFIRMACIÓN DEL PROVEEDOR
                $detail->provider_confirmation_number,
                //TIPO DE SERVICIO
                $service,
                //PRECIO PÚBLICO
                $detail->public_price,
                //PRECIO NETO
                $detail->net_price,
                //COMISIÓN
                $detail->agent_commission
            ];
        }

        $this->result = $excel_array;
    }

    public function collection()
    {
        return new Collection($this->result);
    }
}
