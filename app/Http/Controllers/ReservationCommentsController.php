<?php

namespace App\Http\Controllers;

use App\Models\ReservationComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationCommentsController extends MainController
{
    protected $model = ReservationComment::class;
    protected function getValidations(): array
    {
        $result = [
            'reservation_id' => 'required|exists:reservations,id',
            'comment' => 'required',
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
            'reservation_id.required' => 'Debe indicar la reserva a comentar',
            'reservation_id.exists' => 'No se ha encontrado la reserva especificada',
            'comment.required' => 'Debe ingresar el comentario',
            'id.required' => 'Se debe especificar el código del comentario a editar'
        ];
    }

    public function save($model, Request $request){
        $model->reservation_id = $request->input('reservation_id');
        $model->user_id = Auth::id();
        $model->comment = $request->input('comment');
        $model->save();
        return $model;
    }
}
