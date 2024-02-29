<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\GeneralAnnouncement;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data = [];
        $data['result'] = 'success';
        $status_code = 200;
        try {
            $user = Auth::user();
            //últimos 3 anuncios generales
            $data['announcements'] = GeneralAnnouncement::orderBy('id', 'DESC')->take(3)->get();

            if ($user->hasPermission('VIEW_GENERAL_DASHBOARD')) {
                $users = User::withCount(['reservations' => function($q){
                    $q->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                }])->with(['reservations' => function($q){
                    $q->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                }])->get();

                $data['user_top_reservations'] = $users->sortByDesc(function ($item) {
                    return ($item->reservations_count);
                })->first();

                $data['user_top_reservations_total'] = $data['user_top_reservations']->reservations->sum('public_price');

                $data['user_top_public_price'] = $users->sortByDesc(function ($item) {
                    return $item->reservations->sum('public_price');
                })->first();
                //Top 3 de usuarios con más reservas en el mes
                $data['user_top_three_reservations'] = $users->sortByDesc(function ($item) {
                    return ($item->reservations_count);
                })->take(3);
                //Top 3 de usuarios con más ventas (suma de precio público) en el mes
                $data['user_top_three_public_price'] = $users->sortByDesc(function ($item) {
                    return $item->reservations->sum('public_price');
                })->take(3)->map(function($item){
                    $item->total_sales = $item->reservations->sum('public_price');
                });
                //Top 3 de usuarios con más ganancias (resta de precio públic - precio neto de sus reservas) en el mes
                $data['user_top_three_public_price'] = $users->sortByDesc(function ($item) {
                    return $item->reservations->sum('public_price') - $item->reservations->sum('net_price');
                })->take(3);

                $month_reservations = Reservation::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

                //Suma de ventas totales del mes actual (precio público)
                $data['month_sales'] = $month_reservations->sum('public_price');
                //Suma de ganancia total del mes actual (precio público - precio neto)
                $data['month_profit'] = $month_reservations->sum('public_price') - $month_reservations->sum('net_price');
                //Cantidad de reservas hechas en el mes
                $data['month_reservations'] = count($month_reservations);
                //Cantidad de clientes nuevos en el mes
                $data['month_new_customers'] = count(Customer::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get());
                //Cantidad de reservas que tienen servicios de hotel, vuelos, pickup, tour y renta de coches

                $tmp = [
                    'HotelReservation' => Reservation::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\HotelReservation');
                        $query->where('cancelled_at', null);
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\HotelReservation')->get()),
                    'TourReservation' => Reservation::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\TourReservation');
                        $query->where('cancelled_at', null);
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\TourReservation')->get()),
                    'FlightReservation' => Reservation::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\FlightReservation');
                        $query->where('cancelled_at', null);
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\FlightReservation')->get()),
                    'CarRentalReservation' => Reservation::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\CarRentalReservation');
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\CarRentalReservation')->get()),
                    'PickupReservation' => Reservation::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\PickupReservation');
                        $query->where('cancelled_at', null);
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\PickupReservation')->get()),
                ];

                $data['reservation_service_types'] = [
                    'HotelReservation' => count($tmp['HotelReservation']),
                    'TourReservation' => count($tmp['TourReservation']),
                    'FlightReservation' => count($tmp['FlightReservation']),
                    'CarRentalReservation' => count($tmp['CarRentalReservation']),
                    'PickupReservation' => count($tmp['PickupReservation']),
                ];
            } else if ($user->hasPermission('VIEW_INDIVIDUAL_DASHBOARD')) {
                $month_reservations = Reservation::where('user_id', $user->id)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

                return Response()->json($month_reservations)->setStatusCode($status_code);
                //Suma de ventas totales del mes actual (precio público) del usuario autenticado
                $data['month_sales'] = $month_reservations->sum('public_price');
                //Suma de ganancia total del mes actual (precio público - precio neto) del usuario autenticado
                $data['month_profit'] = $month_reservations->sum('public_price') - $month_reservations->sum('net_price');
                //Cantidad de reservas hechas en el mes del usuario autenticado
                $data['month_reservations'] = count($month_reservations);
                //Cantidad de clientes nuevos en el mes del usuario autenticado
                $data['month_new_customers'] = count(Customer::whereHas('reservations', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get());
                //Cantidad de reservas que tienen servicios de hotel, vuelos, pickup, tour y renta de coches del usuario autenticado
                $reservations = Reservation::where('user_id', $user->id);

               /* $data['reservation_service_types'] = [
                    'HotelReservation' => count($reservations->whereRelation('reservation_details', 'App\\Models\\HotelReservation')->get()),
                    'TourReservation' => count($reservations->whereRelation('reservation_details', 'App\\Models\\TourReservation')->get()),
                    'FlightReservation' => count($reservations->whereRelation('reservation_details', 'App\\Models\\FlightReservation')->get()),
                    'CarRentalReservation' => count($reservations->whereRelation('reservation_details', 'App\\Models\\CarRentalReservation')->get()),
                    'PickupReservation' => count($reservations->whereRelation('reservation_details', 'App\\Models\\PickupReservation')->get()),
                ];*/


                $tmp = [
                    'HotelReservation' => $reservations::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\HotelReservation');
                        $query->where('cancelled_at', null);
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\HotelReservation')->get()),
                    'TourReservation' => $reservations::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\TourReservation');
                        $query->where('cancelled_at', null);
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\TourReservation')->get()),
                    'FlightReservation' => $reservations::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\FlightReservation');
                        $query->where('cancelled_at', null);
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\FlightReservation')->get()),
                    'CarRentalReservation' => $reservations::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\CarRentalReservation');
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\CarRentalReservation')->get()),
                    'PickupReservation' => $reservations::whereHas('reservation_details', function ($query) {
                        $query->where('reservable_type', 'App\\Models\\PickupReservation');
                        $query->where('cancelled_at', null);
                    })->get(), // count($reservations->whereRelation('reservation_details', 'App\\Models\\PickupReservation')->get()),
                ];

                $data['reservation_service_types'] = [
                    'HotelReservation' => count($tmp['HotelReservation']),
                    'TourReservation' => count($tmp['TourReservation']),
                    'FlightReservation' => count($tmp['FlightReservation']),
                    'CarRentalReservation' => count($tmp['CarRentalReservation']),
                    'PickupReservation' => count($tmp['PickupReservation']),
                ];

            }
        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getTrace();
            $status_code = 500;
        }
        return Response()->json($data)->setStatusCode($status_code);
    }
}
