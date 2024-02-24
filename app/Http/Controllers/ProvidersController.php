<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProvidersController extends MainController
{
    protected $model = Provider::class;

    protected function getValidations(): array
    {
        $result = [
            'name' => 'required',
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
            'name.required' => 'El nombre es requerido',
            'id.required' => 'Se debe especificar el código del proveedor a editar'
        ];
    }

    public function save($model, Request $request)
    {
        $model->name = $request->input('name');
        $model->bank = $request->input('bank');
        $model->business_name = $request->input('business_name');
        $model->RFC = $request->input('RFC');
        $model->clabe = $request->input('clabe');
        $model->notification_mail = $request->input('notification_mail');
        $model->contact_name = $request->input('contact_name');
        $model->phone = $request->input('phone');
        $model->has_hotels = $request->input('has_hotels');
        $model->has_tours = $request->input('has_tours');
        $model->has_car_rentals = $request->input('has_car_rentals');
        $model->has_pickups = $request->input('has_pickups');
        $model->has_flights = $request->input('has_flights');
        $model->balance = $request->input('balance');
        $model->save();
        return $model;
    }
}
