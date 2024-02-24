<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MultimediaController extends MainController
{
    //
    protected $model = Multimedia::class;

    public function messages()
    {
        return [
            'filename.required' => 'Falta el nombre de archivo',
            'filename.unique' => 'El archivo ya existe en el servidor, cambia de nombre el archivo',
            'file_url.required' => 'No se ha podido subir el archivo'
        ];
    }

    public function store(Request $request)
    {
        $data = [];
        $data['result'] = 'success';
        $status_code = 200;
        try {
            $validator = validator(
                $request->all(), [
                //'filename' => 'required|unique:multimedia,filename',
                'file_url' => 'required',

            ], $this->messages()
            );
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 500);
            }

            $ext = pathinfo($request->input('filename'), PATHINFO_EXTENSION);
            $filename = Str::random() . '.' . $ext;
            $this->create_image($request->input('file_url'), '/multimedia/', $filename);

            $m = new Multimedia();
            $m->filename = $filename;
            $m->file_url = url(Storage::url('multimedia/' . $m->filename));
            $m->save();

            $data['data'] = $m;
        } catch (Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }

        return Response()->json($data)->setStatusCode($status_code);
    }

}
