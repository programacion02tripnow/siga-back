<?php

namespace App\Http\Controllers;

use App\Models\PaymentAuthenticationRequest;
use App\Models\ReservationPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentAuthenticationRequestsController extends MainController
{
    protected $model = PaymentAuthenticationRequest::class;

    public function save($model, Request $request){
        $model->user_id =Auth::id();
        //$model->authorizing_user_id = $request->input('authorizing_user_id');
        $model->token = Str::random(10);
        $model->expiry_date = date( 'Y-m-d H:i:s', strtotime( '+2 hour' , strtotime(date('Y-m-d H:i:s'))));
        $model->reservation_payment_id = $request->input('reservation_payment_id');
        $model->used = false;
        $model->save();
        return $model;
    }

    public function authorize_payment(Request $request){
        $data = [];
        $data['result'] = '';
        $status_code = 200;
        try {
            $auth_request = PaymentAuthenticationRequest::where('token', $request->input('token'))->first();
            if($auth_request && $auth_request->reservation_payment_id === $request->input('reservation_payment_id')){
                $auth_request->used = true;
                $auth_request->save();
                if(date('Y-m-d H:i:s', strtotime($auth_request->expiry_date)) > date('Y-m-d H:i:s')){
                    $data['data'] = $auth_request;
                } else {
                    throw new \Exception('El token ha expirado', 500);
                }
            }
        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }
        return Response()->json($data)->setStatusCode($status_code);

    }
}
