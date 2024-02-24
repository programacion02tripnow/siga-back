<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundsController extends MainController
{
    protected $model = Refund::class;

    protected function getValidations(): array
    {
        $result = [
            'amount' => 'required|numeric',
        ];
        $request = request();
        if ($request->isMethod('PUT')) {
            $result['id'] = 'required';
        }

        return $result;
    }

    protected function getMessages(): array
    {
        return [
            'amount.required' => 'Debe indicar el monto del reembolso',
            'amount.numeric' => 'El monto debe ser numérico',
            'id.required' => 'Se debe especificar el código del reembolso a editar'
        ];
    }

    public function save($model, Request $request){
        $model->amount = $request->input('amount');
        $model->token = bin2hex(random_bytes(5));
        $model->status = 1;
        $model->user_id = Auth::id();
        $model->save();

        return $model;
    }

}
