<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Voucher</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"
    <style>

        * {
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            line-height: 1.2;
        }

        table {
            width: 100%;
            line-height: 10px;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .text-justify {
            text-align: justify;
        }

        .detail-table {
            border: 2px solid black;
            padding: 0;
            border-spacing: 0;
        }

        .detail-table thead {
            background: #cecece;
        }

        .detail-table .subheader {
            background: #eaeaea;

        }

        .detail-table .subheader td, .detail-table thead td {
            border-style: solid;
            border-color: black;
            border-width: 1px 1px 1px 0;
            padding: 10px;
        }

        .detail-table .info td {
            border-style: solid;
            border-color: black;
            border-width: 1px 0 0 1px;
        }

        .detail-table td p {
            margin: 8px;
        }
        .danger {
            color: red;
        }
        h1, h2 {
            color: #000262;
            font-weight: bolder;
        }
        h1 {
            font-size: 16px;
        }
        h2 {
            font-size: 14px;
        }
        ul > li {
            margin: 10px;
        }

        hr {
            width: 90%;
            border: lightgrey 1px solid;
        }
        .blue-text {
            color: #000262;
            font-weight: bolder;
         }
        p {
            color: #5a5b56;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <td>
            <table>
                <tr>
                    <td>
                        <h1>GRUPO CONSOLIDADOR DE <br> RESERVACIONES S DE RL DE CV </h1>
                    </td>
                    <td style="width:300px;">
                        <img alt="" src="{{asset('logo.png')}}" style="display: block; padding: 20px; width: 200px">
                    </td>

                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <h2 class="text-left">TITULAR DE LA RESERVACIÓN</h2>
            <p class="text-left">{{$reservation_detail->reservation->customer->first_name}} {{$reservation_detail->reservation->customer->last_name}}</p>
            <hr>
        </td>
    </tr>
    <tr>
        <td>
            <h2 class="text-center">SERVICIOS CONTRATADOS</h2>
        </td>
    </tr>
    <tr>
        <td>
            <div style="width: 100%">
                @switch($reservation_detail->reservable_type)
                    @case('App\\Models\\HotelReservation')
                        <ul>
                            <li>
                                <b>Hotel:</b> {{$reservation_detail->reservable->hotel_name}}
                            </li>
                            <li>
                                <b>Número de habitaciones:</b> {{count($reservation_detail->reservable->hotel_reservation_rooms)}}
                            </li>

                            <li>
                                <b>Cantidad de adultos:</b> {{$reservation_detail->reservable->adults_quantity}}
                            </li>
                            <li>
                                <b>Cantidad de menores:</b> {{$reservation_detail->reservable->minors_quantity}}
                            </li>
                            <li>
                                <b>Check in:</b> {{date('d-m-Y', strtotime($reservation_detail->reservable->check_in))}}
                            </li>
                            <li>
                                <b>Check out:</b> {{date('d-m-Y', strtotime($reservation_detail->reservable->check_out))}}
                            </li>
                        </ul>
                        @break
                    @case('App\\Models\\TourReservation')
                        <ul>
                            <li>
                                <b>Tour:</b> {{$reservation_detail->reservable->tour_name}}
                            </li>
                            @if($reservation_detail->reservable->package_name!='')
                                <li>
                                    <b>Nombre del paquete:</b> {{$reservation_detail->reservable->package_name}}
                                </li>
                            @endif
                            <li>
                                <b>Cantidad de adultos:</b> {{$reservation_detail->reservable->adults_quantity}}
                            </li>
                            <li>
                                <b>Cantidad de menores:</b> {{$reservation_detail->reservable->minors_quantity}}
                            </li>
                            <li>
                                <b>Fecha del tour:</b> {{date('d-m-Y', strtotime($reservation_detail->reservable->date))}}
                            </li>
                        </ul>
                        @break
                    @case('App\\Models\\FlightReservation')
                        <ul>
                            <li>
                                <b>Aerolínea:</b> {{$reservation_detail->reservable->airline}}
                            </li>
                            <li>
                                <b>Cantidad de adultos:</b> {{$reservation_detail->reservable->adults_quantity}}
                            </li>
                            <li>
                                <b>Cantidad de menores:</b> {{$reservation_detail->reservable->minors_quantity}}
                            </li>
                            <li>
                                <b>PNR:</b> {{$reservation_detail->reservable->PNR}}
                            </li>
                        </ul>
                        @break
                    @case('App\\Models\\CarRentalReservation')
                        <ul>
                            <li>
                                <b>Información de entrega:</b> {{date('d-m-Y H:i', strtotime($reservation_detail->reservable->datetime_pickup))}}, {{$reservation_detail->reservable->pickup}}
                            </li>
                            <li>
                                <b>Información de devolución:</b> {{date('d-m-Y H:i', strtotime($reservation_detail->reservable->return_datetime))}}, {{$reservation_detail->reservable->return}}
                            </li>
                            <li>
                                <b>Tipo de vehículo:</b> {{$reservation_detail->reservable->car_category}}
                            </li>
                            <li>
                                <b>Agencia:</b> {{$reservation_detail->reservable->agency_name}}
                            </li>
                        </ul>
                        @break
                    @case('App\\Models\\PickupReservation')
                        <ul>
                            <li>
                                <b>Punto de encuentro:</b> {{$reservation_detail->reservable->pickup}}
                            </li>
                            <li>
                                <b>Tipo de vehículo:</b> {{$reservation_detail->reservable->transportation_type}}
                            </li>
                            <li>
                                <b>Cantidad de adultos:</b> {{$reservation_detail->reservable->adults_quantity}}
                            </li>
                            <li>
                                <b>Cantidad de menores:</b> {{$reservation_detail->reservable->minors_quantity}}
                            </li>
                            <li>
                                <b>Fecha/Hora:</b> {{date('d-m-Y H:i', strtotime($reservation_detail->reservable->datetime))}}
                            </li>

                            <li>
                                <b>Tipo de servicio:</b> {{$reservation_detail->reservable->type === 1 ? 'Privado' : 'Compartido'}}
                            </li>

                            <li>
                                <b>Destino:</b> {{$reservation_detail->reservable->destination}}
                            </li>
                        </ul>
                        @break
                @endswitch

                <div style="padding: 10px 50px;">
                    <p class="text-right blue-text">PRECIO:</p>
                    <p class="text-right">$ {{number_format($reservation_detail->public_price, 2, '.', ',')}} MXN</p>
                </div>


            </div>
            <hr>
        </td>
    </tr>
    <tr>
        <td>
            <h2 class="text-center text-bold">TÉRMINOS Y CONDICIONES</h2>
            <p class="text-justify">
                {{$reservation_detail->terms_conditions}}
            </p>
        </td>
    </tr>
</table>
</body>
</html>
