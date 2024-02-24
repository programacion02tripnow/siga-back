<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends MainController
{
    protected $model = User::class;

    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->get('username'), 'password' => $request->get('password')])) {
            // Fire off the internal request.
            $token = Request::create(
                'api/oauth/token',
                'POST',
                $request->toArray()
            );
            $response = app()->handle($token);
            $response = json_decode($response->getContent(), true);
            if (isset($response['error'])) {
                var_dump($response);
                return Response()->json($response)->setStatusCode(401);
            }

            $u = Auth::user();
            $u->multimedia;
            $u->ability;
            $response['user'] = $u;
            return Response()->json($response);
            /*
             * userData,
             * accessToken,
             * refreshToken,
             */

            // return Response()->json(['user' => $u, 'accessToken' => $token->accessToken, 'refreshToken' => $token]);
        }

        return Response()->json(['error' => ['Email' => ['El usuario y/o la contraseña son incorrectos']]])->setStatusCode(403);
    }


    public function get_user_info()
    {
        $u = Auth::user();
        $u->multimedia;
        $u->ability;
        return Response()->json(['result' => 'success', 'data' => $u]);
    }

    protected function getValidations(): array
    {
        $result = [
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'multimedia' => 'required',
        ];
        $request = request();
        if ($request->isMethod('POST')) {
            $result['password'] = 'required';
        } elseif ($request->isMethod('PUT')) {
            $result['id'] = 'required';
        }

        return $result;
    }

    protected function getMessages(): array
    {
        return [
            'username.required' => 'El correo electrónico es requerido',
            'first_name.required' => 'El nombre es requerido',
            'last_name.required' => 'El apellido es requerido',
            'phone.required' => 'El teléfono es requerido',
            'password.required' => 'La contraseña es requerida',
            'id' => 'Se debe especificar el código del usuario a editar',
            'multimedia.required' => 'Debe de seleccionar una foto de perfil'
        ];
    }

    public function save($model, Request $request)
    {
        $model->username = $request->input('username');
        if ($request->filled('password')) {
            $model->password = bcrypt($request->input('password'));
        }
        $model->role_id = $request->input('role');
        $model->first_name = $request->input('first_name');
        $model->last_name = $request->input('last_name');
        $model->phone = $request->input('phone');
        $model->birthday = $request->input('birthday');

        $multimedia = $request->input('multimedia')[0];
        $model->multimedia_id = $multimedia['id'];

        //commissions
        /*$model->hotels_commission = $request->input('hotels_commission');
        $model->tours_commission = $request->input('tours_commission');
        $model->car_rentals_commission = $request->input('car_rentals_commission');
        $model->pickups_commission = $request->input('pickups_commission');
        $model->flights_commission = $request->input('flights_commission');*/

        $model->save();
        return $model;
    }

    function validateDestroy($model): bool
    {
        if ($model->id === Auth::id()) {
            throw new \Exception('No puede eliminar su propio usuario', 405);
        }

        return true;
    }

    public function get_users_has_permission($permission)
    {
        $users = User::getHasPermission($permission);
        return Response()->json(['result' => 'success', 'data' => $users]);
    }
}
