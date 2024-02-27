<?php

namespace App\Http\Controllers;

use App\Mail\SettlementRequest;
use App\Mail\TravelinWalletUseRequest;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SettlementsController extends MainController
{
    protected $model = Settlement::class;

    protected function getValidations(): array
    {
        $result = [
            'reservation_detail_id' => 'required|exists:reservation_details,id',
            'settlement_method' => 'required',
        ];
        $request = request();
        if ($request->isMethod('PUT')) {
            $result['authorization_user_id'] = 'required_with:auth_token|exists:users,id';
            $result['last4'] = 'required_if:settlement_method,3';
            $result['id'] = 'required';
        }

        return $result;
    }

    protected function getMessages(): array
    {
        return [
            'reservation_detail_id.required' => 'Debe de seleccionar un servicio a liquidar',
            'reservation_detail_id.exists' => 'Debe de seleccionar un servicio a liquidar',
            'settlement_method.required' => 'Debe indicar el método de liquidación',
            'authorization_user_id.required_with' => 'Debe indicar el usuario que autoriza el pago',
            'authorization_user_id.exists' => 'No se ha encontrado el usuario que autoriza el pago',
            'last4.required_if' => 'Debe indicar los últimos 4 dígitos de la tarjeta de crédito/débito',
            'id.required' => 'Se debe especificar el código del recurso a editar'
        ];
    }

    public function save($model, Request $request){
        $model->reservation_detail_id = $request->input('reservation_detail_id');
        $model->user_id = Auth::id();
        $model->settlement_method = $request->input('settlement_method'); //1=> Transferencia, 2=>Monedero, 3=>Tarjeta de crédito
        $model->date = date('Y-m-d H:i:s');

        if($model->settlement_method === 3){
            $model->last4 =  $request->input('last4');
            $model->authorization_user_id = Auth::id();
            $model->authorization_date = date('Y-m-d H:i:s');
        }

        if ($request->isMethod('POST')) {
            if ($model->settlement_method === 2) {
                $model->auth_token = Str::random(6);
                if ($model->reservation_detail->provider->balance < $model->reservation_detail->net_price) {
                    throw new \Exception('Saldo insuficiente en el monedero del proveedor', 500);
                }

                $model->save();

                // Mail::send(new TravelinWalletUseRequest($model));
            } else if ($model->settlement_method === 1){
                $model->save();
                // Mail::send(new SettlementRequest($model));
            }
        }
        if ($request->isMethod('PUT')) {
            if (!$request->filled('auth_token') && $request->input('auth_token') !== $model->auth_token) {
                throw new \Exception('Autorización no válida, favor de verificar', 500);
            }
            $model->authorization_user_id = $request->input('authorization_user_id');
            $model->reservation_detail->provider->balance -= $model->reservation_detail->net_price;
            $model->reservation_detail->provider->save();
            $model->authorization_date = date('Y-m-d H:i:s');
        }

        $model->save();

        return $model;
    }
}
