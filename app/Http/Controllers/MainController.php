<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\VarDumper\VarDumper;

class MainController extends Controller
{
    //
    protected $model = User::class;

    public function experimental_filter(Request $request, $related = false)
    {
        $filter = $request->input('filter');
        $data['data'] = $this->model::with([]);

        if ($filter) {
            $data['data'] = $this->filter($data['data'], $filter);
        }
        if ($related) {
            $related = unserialize($related);
            $data['data'] = $data['data']->with($related);
        }
        $data['data'] = $this->conditions($data['data']);

        return json_encode(["result" => "success", "data" => $data['data']->get()], JSON_NUMERIC_CHECK);
    }

    public function filter($query, $filter)
    {
        $fn = function () {
        };

        foreach ($filter as $value) {
            if (strpos($value['field'], '.') !== false) {
                $sp = array_reverse(explode('.', $value['field']));

                foreach ($sp as $index => $field) {
                    if ($index == 0) {
                        $function_name = $value['function'];
                        $fn = function ($q) use ($field, $value, $function_name) {
                            if (isset($value['operator'])) {
                                if ($value['operator'] === 'contains') {
                                    $value['operator'] = 'like';
                                    $value['value'] = '%' . $value['value'] . '%';
                                }
                                if ($function_name !== 'where') {
                                    $q->where($field, $value['operator'], $value['value']);
                                } else {
                                    $q->$function_name($field, $value['operator'], $value['value']);
                                }
                            } else {
                                $q->$function_name($field, $value['value']);
                            }
                        };
                    } else if (count($sp) - 1 == $index) {
                        $data['data'] = $query->whereHas($field, $fn);
                    } else {
                        $fn = function ($q) use ($field, $fn, $function_name) {
                            if ($function_name !== 'where') {
                                $q->$function_name($field, $fn);
                            } else {
                                $q->whereHas($field, $fn);
                            }
                        };
                    }
                }

            } else {
                if (isset($value['operator']) && $value['operator'] === 'contains') {
                    $value['operator'] = 'like';
                    $value['value'] = '%' . $value['value'] . '%';
                }
                $function_name = $value['function'];
                $params = [$value['field']];
                if (isset($value['operator'])) {
                    $params[] = $value['operator'];
                }

                $params[] = $value['value'];

                $data['data'] = $query->$function_name(...$params);

            }
        }

        return $query;
    }

    public function conditions($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function create_image($imagen, $carpeta, $nombre)
    {
        try {
            if (!is_dir(storage_path('app/public' . $carpeta))) {
                File::makeDirectory(storage_path('app/public' . $carpeta), $mode = 0777, $recursive = true, $force = true);
            }
            $base_to_php = explode(',', $imagen);
            $data = base64_decode($base_to_php[1]);
            file_put_contents(storage_path('app/public' . $carpeta . $nombre), $data);

            return 'app/public' . $carpeta . $nombre;
        } catch (Exception $ex) {
            throw new Exception('No se ha podido crear el archivo en el servidor: ' . $ex->getMessage(), 500);
        }
    }

    /**
     * Display a listing of the resource.
     * @param boolean $related
     * @return Response
     */
    public function index($related = false)
    {
        //
        $data = [];
        $data['result'] = 'error';
        $status_code = 200;
        try {
            $user = Auth::user();
            if (isset($this->model::$permissions)) {
                if (!$user->hasPermission($this->model::$permissions['view'])) {
                    throw new \Exception('No tiene permiso para ver este recurso', 403);
                }
            }


            $data['result'] = 'success';
            if ($related) {
                $related = unserialize($related);
                $data['data'] = $this->model::with($related)->orderBy('id', 'desc');//->paginate(10);
            } else {
                $data['data'] = $this->model::orderBy('id', 'desc');//->paginate(10);
            }
            $data['data'] = $this->conditions($data['data']);
            $data['data'] = $data['data']->paginate(10);

        } catch (Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = 500;
        }
        return Response()->json($data, $status_code, [], JSON_NUMERIC_CHECK)->setStatusCode($status_code);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param $related
     * @return Response
     */
    public function show($id, $related = false)
    {
        //
        $data = [];
        $data['result'] = 'success';
        $status_code = 200;

        try {
            $data['data'] = $this->model::with([]);
            if ($related) {
                $related = unserialize($related);
                $data['data'] = $data['data']->with($related);
            }

            $data['data'] = $this->conditions($data['data']);
            $data['data'] = $data['data']->find($id);

            if (!$data['data']) {
                throw new Exception('No se han encontrado resultados', 404);
            }

        } catch (Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }

        return Response()->json($data, $status_code, [], JSON_NUMERIC_CHECK)->setStatusCode($status_code);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        //
        return Response('El formulario se accede desde el admin')->setStatusCode(500);
    }

    public function save($model, Request $request)
    {

    }

    protected function getValidations(): array
    {
        return [];
    }

    protected function getMessages(): array
    {
        return [];
    }

    public function store(Request $request)
    {
        $data = [];
        $data['result'] = 'success';
        $status_code = 200;
        try {
            $user = Auth::user();
            if (isset($this->model::$permissions)) {
                if (!$user->hasPermission($this->model::$permissions['create'])) {
                    throw new \Exception('No tiene permiso para crear este recurso', 403);
                }
            }
            $validator = Validator::make($request->all(), $this->getValidations(), $this->getMessages());

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 500);
            }

            $data['data'] = $this->save(new $this->model(), $request);

        } catch (\Exception $ex) {

            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = 500;
        }

        return response()->json($data)->setStatusCode($status_code);
    }

    public function update(Request $request, $id)
    {
        $data = [];
        $data['result'] = 'success';
        $status_code = 200;
        try {
            $user = Auth::user();
            if (isset($this->model::$permissions)) {
                if (!$user->hasPermission($this->model::$permissions['edit'])) {
                    throw new \Exception('No tiene permiso para editar este recurso', 403);
                }
            }
            $validator = Validator::make($request->all(), $this->getValidations(), $this->getMessages());

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->first(), 500);
            }

            $u = $this->model::find($id);
            if (!$u) {
                throw new \Exception('No se ha encontrado el recurso', 404);
            }
            $data['data'] = $this->save($u, $request);


        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = 500;
        }

        return response()->json($data)->setStatusCode($status_code);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return Response('El formulario se accede desde el admin')->setStatusCode(500);
    }

    function deleteDependencies($model)
    {

    }

    function validateDestroy($model): bool
    {
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|object
     */
    public function destroy($id)
    {
        //
        $data = [];
        $data['result'] = '';
        $status_code = 200;
        try {
            $user = Auth::user();
            if (isset($this->model::$permissions)) {
                if (!$user->hasPermission($this->model::$permissions['delete'])) {
                    throw new \Exception('No tiene permiso para eliminar este recurso', 403);
                }
            }
            $usesSoft = false;
            if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->model))) {
                $usesSoft = true;
                $d = $this->model::withTrashed()->find($id);
            } else {
                $d = $this->model::find($id);
            }


            if (!$d) {
                throw new Exception('No se han encontrado resultados', 404);
            }

            if ($usesSoft && $d->trashed()) {
                $d->restore();
            } else if ($this->validateDestroy($d)) {
                if (!$usesSoft) {
                    $this->deleteDependencies($d);
                }
                $d->delete();
            } /*else {
                throw new Exception('No se ha permitido borrar el registro', 405);
            }*/

            $data['result'] = 'success';

        } catch (Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = 500;
        }
        return Response()->json($data)->setStatusCode($status_code);
    }

    public function renderMainLayout(string $view, $data = [], $code = 200)
    {
        $data['locations'] = Location::all();
        $data['featured_services'] = Service::where('featured', true)->get();

        // return view($view, $data);
        return response()->view($view, $data)->setStatusCode($code);
    }

}
