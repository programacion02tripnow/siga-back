<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodAdditionalField;
use Illuminate\Http\Request;

class PaymentMethodsController extends MainController
{
    protected $model = PaymentMethod::class;

    protected function getValidations(): array
    {
        $result = [
            'name' => 'required',
            // 'requires_auth' => 'required',
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
            'name.required'=>'El nombre es requerido',
            'requires_auth.required'=>'Debe especificar si requiere autenticación',
            'id'=>'Se debe especificar el código del método de pago a editar'
        ];
    }

    public function save($model, Request $request){
        $model->name = $request->input('name');
        $model->requires_auth = false; // $request->input('requires_auth');
        $model->save();

        $saveIds = [];
        if($request->filled('payment_method_additional_fields')) {
            foreach ($request->input('payment_method_additional_fields') as $field) {
                $paf = PaymentMethodAdditionalField::find($field['id']);
                if (!$paf) {
                    $paf = new PaymentMethodAdditionalField();
                }
                $paf->payment_method_id = $model->id;
                $paf->name = $field['name'];
                $paf->is_required = $field['is_required'];
                $paf->type = $field['type'];
                $paf->save();
                $saveIds[] = $paf->id;
            }
        }
        if($request->isMethod('PUT') && count($saveIds) > 0){
            $model->payment_method_additional_fields()->whereNotIn('id', $saveIds)->delete();
        }

        return $model;
    }
}
