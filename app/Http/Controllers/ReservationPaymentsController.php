<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\ReservationPayment;
use App\Models\ReservationPaymentAdditionalValue;
use App\Models\ReservationPaymentDate;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationPaymentsController extends MainController
{
    protected $model = ReservationPayment::class;

    public function save($model, Request $request)
    {
        $model->reservation_id = $request->input('reservation_id');
        $model->amount = $request->input('amount');
        $model->date = date('Y-m-d H:i:s');

        // $model->payment_method_text = $request->input('payment_method_text');
        $model->user_id = Auth::id();

        if($request->input('payment_method_id') === 0){
            $booking = Reservation::find($request->input('reservation_id'));
            $bookingDetails = $booking->reservation_details;

            $customerWallet = $booking->customer->wallet;

            $booking->customer->update([
                'wallet' => abs($customerWallet) - abs(floatval($request->input('amount')))
            ]);


            // $refund = Refund::where('token', $request->input('reservation_payment_additional_values')[0]['value'])->first();
            // $refund->status = 2;
            // $refund->save();
            $model->payment_method_id = $request->input('payment_method_id');
            $model->payment_method_text = "Pago con monedero ";
            $model->save();

        } else {
            $model->payment_method_id = $request->input('payment_method_id');
            $model->save();
            // foreach ($request->input('reservation_payment_additional_values') as $value){
            //     $additional_value = new ReservationPaymentAdditionalValue();
            //     $additional_value->reservation_payment_id = $model->id;
            //     $additional_value->payment_method_additional_field_id = $value['payment_method_additional_field_id'];
            //     $additional_value->value = $value['value'];
            //     $additional_value->save();
            // }
        }

        if ($request->has('payment_date_id')) {
            $rpd = ReservationPaymentDate::find($request->input('payment_date_id'));
            if ($rpd) {
                $rpd->reservation_payment_id = $model->id;
                $rpd->save();
            }
        }

        return $model;
    }
}
