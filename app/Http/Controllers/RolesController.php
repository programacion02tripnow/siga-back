<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;

class RolesController extends MainController
{
    protected $model = Role::class;

    protected function getValidations(): array
    {
        $result = [
            'name' => 'required',
            'role_permissions' => 'required',
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
            'role_permissions.required' => 'Debe indicar los permisos del rol',
            'id.required' => 'Se debe especificar el código del rol a editar'
        ];
    }

    public function save($model, Request $request)
    {
        $model->name = $request->input('name');
        $model->save();

        $model->role_permissions()->delete();
        foreach ($request->input('role_permissions') as $permission) {
            $rp = new RolePermission();
            $rp->role_id = $model->id;
            $rp->module_permission_id = $permission['module_permission_id'];
            $rp->save();
        }
    }

    public function delete_role(Request $request)
    {
        $data = [];
        $data['result'] = '';
        $status_code = 200;
        try {
            $role = $this->model::find($request->input('id'));

            if (!$role) {
                throw new \Exception('No se han encontrado resultados', 404);
            }
            $newRole = $this->model::find($request->input('role_id'));
            if (!$newRole) {
                throw new \Exception('El nuevo rol de los usuarios afectados no existe', 404);
            }

            $users = User::where('role_id', $role->id)->get();
            foreach ($users as $user) {
                $user->role_id = $newRole->id;
                $user->save();
            }
            $role->delete();

            $data['result'] = 'success';

        } catch (\Exception $ex) {
            $data['result'] = 'error';
            $data['error'] = $ex->getMessage();
            $status_code = $ex->getCode();
        }
        return Response()->json($data)->setStatusCode($status_code);
    }
}
