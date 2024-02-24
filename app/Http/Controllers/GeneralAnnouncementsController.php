<?php

namespace App\Http\Controllers;

use App\Models\GeneralAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralAnnouncementsController extends MainController
{
    protected $model = GeneralAnnouncement::class;

    protected function getValidations(): array
    {
        $result = [
            'announcement' => 'required',
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
            'announcement.required'=>'El texto del anuncio es requerido',
            'id.required'=>'Se debe especificar el código del anuncio a editar'
        ];
    }

    public function save($model, Request $request){
        $model->user_id = Auth::id();
        $model->announcement = $request->input('announcement');
        $model->save();

        if ($request->isMethod('put')) {
            $this->create_model_log($model);
        }

        return $model;
    }
}
