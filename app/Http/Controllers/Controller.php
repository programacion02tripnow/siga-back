<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create_model_log($model, $get_original = true){
        $log = new Log();
        $log->logable_type = get_class($model);
        $log->logable_id = $model->id;
        $log->log = json_encode($get_original ? $model->getOriginal() : $model);
        $log->user_id = Auth::id();
        $log->save();
        /*$changed = $model->getDirty();
        $type = class_basename($model);
        foreach ($changed as $attr){
            $text = "El atributo $attr ha cambiado de {$model->getOriginal($attr)} a {$model->$attr}";
            $log = new Log();
            $log->logable_type = $type;
            $log->logable_id = $model->id;
            $log->log = $text;
            $log->user_id = Auth::id();
            $log->save();
        }*/

    }
}
