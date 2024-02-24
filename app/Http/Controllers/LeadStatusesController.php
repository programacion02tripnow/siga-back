<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Http\Request;

class LeadStatusesController extends MainController
{
    protected $model = LeadStatus::class;

    protected function getValidations(): array
    {
        $result = [
            'name' => 'required',
            'color' => 'required',
            'order' => 'required',
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
            'color.required' => 'El color es requerido',
            'order.required' => 'El orden es requerido',
            'id' => 'Se debe especificar el código del estado a editar'
        ];
    }

    public function conditions($query)
    {
        return $query->orderBy('order', 'ASC');
    }

    public function save($model, Request $request)
    {
        $model->name = $request->input('name');
        $model->color = $request->input('color');
        if ($request->input('cancelled_status')) {
            $prev_cancelled = LeadStatus::where('cancelled_status', true)->first();
            if ($prev_cancelled) {
                $order = LeadStatus::orderBy('order', 'DESC')->first()->order + 1;
                $prev_cancelled->cancelled_status = false;
                $prev_cancelled->order = $order;
                $prev_cancelled->save();
            }
            $model->cancelled_status = true;
            $model->order = 0;
        } else {
            // $status = LeadStatus::where('order', $request->input('order'))->get();
            /*if (count($status) > 0) {
                throw new \Exception('El orden seleccionado ya existe', 500);
            }*/
            $model->order = $request->input('order');
        }

        $model->save();
        return $model;
    }

    public function delete_lead_channel(Request $request)
    {
        $data = [];
        $data['result'] = '';
        $status_code = 200;
        try {
            $status = $this->model::find($request->input('id'));

            if (!$status) {
                throw new \Exception('No se han encontrado resultados', 404);
            }
            $newStatus = $this->model::find($request->input('lead_status_id'));
            if (!$newStatus) {
                throw new \Exception('El nuevo estado de los leads afectados no existe', 404);
            }

            $leads = Lead::where('status_id', $status->id)->get();
            foreach ($leads as $lead) {
                $lead->channel_id = $newStatus->id;
                $this->create_model_log($lead);
                $lead->save();
            }
            $status->delete();

            $data['result'] = 'success';

        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }
        return Response()->json($data)->setStatusCode($status_code);
    }

}
