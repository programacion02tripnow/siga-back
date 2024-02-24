<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadChannel;
use Illuminate\Http\Request;

class LeadChannelsController extends MainController
{
    protected $model = LeadChannel::class;

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
            'name.required'=>'El nombre es requerido',
            'id.required'=>'Se debe especificar el código del canal a editar'
        ];
    }

    public function save($model, Request $request){
        $model->name = $request->input('name');
        $model->save();
        return $model;
    }

    public function delete_lead_channel(Request $request)
    {
        $data = [];
        $data['result'] = '';
        $status_code = 200;
        try {
            $channel = $this->model::find($request->input('id'));

            if (!$channel) {
                throw new \Exception('No se han encontrado resultados', 404);
            }
            $newChannel = $this->model::find($request->input('lead_channel_id'));
            if (!$newChannel) {
                throw new \Exception('El nuevo canal de los leads afectados no existe', 404);
            }

            $leads = Lead::where('channel_id', $channel->id)->get();
            foreach($leads as $lead){
                $lead->channel_id = $newChannel->id;
                $this->create_model_log($lead);
                $lead->save();
            }
            $channel->delete();

            $data['result'] = 'success';

        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }
        return Response()->json($data)->setStatusCode($status_code);
    }

}
