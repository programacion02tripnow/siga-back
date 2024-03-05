<?php

namespace App\Http\Controllers;

use App\Imports\LeadsImport;
use App\Models\Customer;
use App\Models\CustomerPhone;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class LeadsController extends MainController
{
    protected $model = Lead::class;

    protected function getValidations(): array
    {
        $result = [
            'first_name' => 'required',
            'email' => 'required|email:rfc',
            //'is_agency' => 'required',
            //'is_mini_vacs' => 'required',
            'lead_channel' => 'required',
            'campaign' => 'required',
            'destination' => 'required',
            'desirable_date' => 'required|date_format:"Y-m-d"',
            'lead_status' => 'required',
            'phone' => 'numeric'
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
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'El formato del correo electrónico es incorrecto',
            'first_name.required' => 'El nombre es requerido',
            'id' => 'Se debe especificar el código del lead a editar',
            'lead_channel.required' => 'El canal es requerido',
            'campaign.required' => 'La campaña es requerida',
            'destination.required' => 'El destino es requerido',
            'desirable_date.required' => 'La fecha estimada es requerida',
            'lead_status.required' => 'El estado del lead es requerido',
            'phone.numeric' => 'El teléfono debe ser numérico'
        ];
    }

    public function save($model, Request $request)
    {
        $model->first_name = Str::title($request->input('first_name'));
        $model->last_name = Str::title($request->input('last_name'));
        $model->email = $request->input('email');
        $model->phone = $request->input('phone');
        $model->is_agency = $request->input('is_agency');
        $model->is_mini_vacs = $request->input('is_mini_vacs');
        $model->lead_channel_id = $request->input('lead_channel');
        $model->campaign = $request->input('campaign');
        $model->destination = $request->input('destination');
        $model->desirable_date = $request->input('desirable_date');
        $model->user_id = Auth::id();

        if ($request->isMethod('put')) {
            if ($request->input('lead_status') !== $model->lead_status_id) {
                $originaStatus = $model->lead_status;
                $newStatus = LeadStatus::find($request->input('lead_status'));
                $user = Auth::user();
                if ($newStatus->order > $originaStatus->order) {
                    if (!$user->hasPermission('UPGRADE_LEAD')) {
                        throw new \Exception('No tiene permiso para modificar el estado de este recurso', 403);
                    }
                } else {
                    if (!$user->hasPermission('DOWNGRADE_LEAD')) {
                        throw new \Exception('No tiene permiso para modificar el estado de este recurso', 403);
                    }
                }
                $model->lead_status_id = $request->input('lead_status');
            }
            $this->create_model_log($model);
        } else {
            $model->lead_status_id = $request->input('lead_status');
        }

        $model->save();

        $saveIds = [];
        foreach ($request->input('lead_comments') as $comment) {
            $cp = new LeadComment();

            $cp->lead_id = $model->id;
            $cp->comment = $comment['comment'];
            $cp->save();
            array_push($saveIds, $cp->id);
        }
        if ($request->isMethod('PUT') && count($saveIds) > 0) {
            $model->lead_comments()->whereNotIn('id', $saveIds)->delete();
        }

        return $model;
    }

    public function destroy($id)
    {
        $data = [];
        $data['result'] = '';
        $status_code = 200;
        try {
            $lead = $this->model::find($id);

            if (!$lead) {
                throw new \Exception('No se han encontrado resultados', 404);
            }
            $status = LeadStatus::where('cancelled_status', true)->first();
            $lead->lead_status_id = $status->id;
            $this->create_model_log($lead);
            $lead->save();


            $data['result'] = 'success';

        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }
        return Response()->json($data)->setStatusCode($status_code);
    }

    public function import_from_excel(Request $request)
    {
        if (Auth::check()) {
            $file = 'temp_' . bin2hex(random_bytes(10)) . '.xlsx';

            $this->create_image($request->input('excel'), 'excel_imports', $file);
            $path = storage_path('excel_imports/' . $file);

            Excel::import(new LeadsImport(), $path);

            if (file_exists($path)) {
                unlink($path);
            }

            return json_encode(['result' => 'success']);
        }
        return json_encode(['result' => 'error', 'error' => 'No tiene acceso']);
    }

    public function lead_to_customer(Request $request)
    {
        $data = [];
        $data['result'] = '';
        $status_code = 200;
        try {
            $lead = $this->model::find($request->input('lead_id'));

            if (!$lead) {
                throw new \Exception('No se ha encontrado el lead', 404);
            }
            $customer = new Customer();
            $customer->first_name = $lead->first_name;
            $customer->last_name = $lead->last_name;
            $customer->email = $lead->email;
            $customer->user_id = Auth::id();
            $customer->save();

            $cp = new CustomerPhone();
            $cp->customer_id = $customer->id;
            $cp->phone = $lead->phone;
            $cp->save();

            $lead->customer_id = $customer->id;
            $lead->save();


            $data['result'] = 'success';

        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }
        return Response()->json($data)->setStatusCode($status_code);
    }

    public function create_comment(Request $request)
    {
        $data = [];
        $data['result'] = '';
        $status_code = 200;
        try {
            $comment = new LeadComment();
            $comment->customer_id = $request->input('lead_id');
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
