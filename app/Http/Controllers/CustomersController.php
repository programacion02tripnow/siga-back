<?php

namespace App\Http\Controllers;

use App\Mail\Welcome;
use App\Models\Customer;
use App\Models\CustomerComment;
use App\Models\CustomerPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomersController extends MainController
{
    protected $model = Customer::class;

    protected function getValidations(): array
    {
        $result = [
            'email' => 'required|unique:customers,email,NULL,id,deleted_at,NULL',
            'first_name' => 'required',
            'last_name' => 'required',
            'birthday' => 'required|date_format:"Y-m-d"',
            //'phones' => 'required'
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
            'email.required'=>'El correo electrónico es requerido',
            'first_name.required'=>'El nombre es requerido',
            'last_name.required'=>'El apellido es requerido',
            'phones.required'=>'El teléfono es requerido',
            'birthday.required'=>'La fecha de nacimiento es requerida',
            'birthday.date_format'=>'El formato de la fecha de nacimiento es incorrecto',
            'id.required'=>'Se debe especificar el código del cliente a editar'
        ];
    }

    public function save($model, Request $request){
        $model->first_name = $request->input('first_name');
        $model->last_name = $request->input('last_name');
        $model->email = $request->input('email');
        $model->birthday = $request->input('birthday');
        $model->user_id = Auth::id();
        $model->save();

        $saveIds = [];
        foreach($request->input('customer_phones') as $phone){
            $cp = CustomerPhone::find($phone['id']);
            if (!$cp) {
                $cp = new CustomerPhone();
            }
            $cp->customer_id = $model->id;
            $cp->phone = $phone['phone'];
            $cp->save();
            array_push($saveIds, $cp->id);
        }
        if($request->isMethod('PUT') && count($saveIds) > 0){
            $model->customer_phones()->whereNotIn('id', $saveIds)->delete();
        }

        /*$comment = new CustomerComment();
        $comment->customer_id = $model->id;
        $comment = $request->input('comment');
        $comment->user_id = Auth::id();
        $comment->save();*/
        $model = $model->refresh();
        if($request->isMethod('POST')){
            Mail::send(new Welcome($model));
        }

        return $model;
    }

    public function create_comment(Request $request)
    {
        $data = [];
        $data['result'] = '';
        $status_code = 200;
        try {
            $comment = new CustomerComment();
            $comment->customer_id = $request->input('customer_id');
            $comment = $request->input('comment');
            $comment->user_id = Auth::id();
            $comment->save();

            $data['result'] = 'success';

        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }
        return Response()->json($data)->setStatusCode($status_code);
    }
}
