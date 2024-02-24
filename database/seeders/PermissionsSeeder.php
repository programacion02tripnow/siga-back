<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $modules = [
            "Dashboard" => [
                ["name" => "VIEW_INDIVIDUAL_DASHBOARD", "label" => "Ver dashboard individual", "level" => 1],
                ["name" => "VIEW_GENERAL_DASHBOARD", "label" => "Ver dashboard general", "level" => 1],
            ],
            "Usuarios y roles" => [
                ["name" => "VIEW_ROLE", "label" => "Ver roles", "level" => 1],
                ["name" => "CREATE_ROLE", "label" => "Crear roles", "level" => 3],
                ["name" => "EDIT_ROLE", "label" => "Editar roles", "level" => 3],
                ["name" => "DELETE_ROLE", "label" => "Eliminar roles", "level" => 3],
                ["name" => "VIEW_USER", "label" => "Ver usuarios", "level" => 2],
                ["name" => "CREATE_USER", "label" => "Crear usuarios", "level" => 3],
                ["name" => "EDIT_USER", "label" => "Editar usuarios", "level" => 3],
                ["name" => "DELETE_USER", "label" => "Borrar usuarios", "level" => 3],
            ],
            "Proveedores" => [
                ["name" => "VIEW_PROVIDER", "label" => "Ver proveedores", "level" => 1],
                ["name" => "CREATE_PROVIDER", "label" => "Crear proveedores", "level" => 2],
                ["name" => "EDIT_PROVIDER", "label" => "Editar proveedores", "level" => 2],
                ["name" => "DELETE_PROVIDER", "label" => "Borrar proveedores", "level" => 2],
            ],
            "Leads" => [
                ["name" => "VIEW_LEAD", "label" => "Ver leads", "level" => 1],
                ["name" => "EDIT_LEAD", "label" => "Editar lead", "level" => 2],
                ["name" => "UPGRADE_LEAD", "label" => "Ascender lead", "level" => 3],
                ["name" => "DOWNGRADE_LEAD", "label" => "Descender lead", "level" => 3],
                ["name" => "DELETE_LEAD", "label" => "Eliminar lead", "level" => 4],
                ["name" => "MANAGE_LEAD_STATUSES", "label" => "Administrar estados de leads", "level" => 5],
                ["name" => "MANAGE_LEAD_CHANNELS", "label" => "Administrar canales de leads", "level" => 5],
            ],

            "Métodos de pago" => [
                ["name" => "VIEW_PAYMENT_METHOD", "label" => "Ver métodos de pagos", "level" => 1],
                ["name" => "CREATE_PAYMENT_METHOD", "label" => "Crear método de pagos", "level" => 2],
                ["name" => "EDIT_PAYMENT_METHOD", "label" => "Editar método de pagos", "level" => 2],
                ["name" => "DELETE_PAYMENT_METHOD", "label" => "Eliminar método de pagos", "level" => 2],
            ],
            "Clientes" => [
                ["name" => "VIEW_CUSTOMER", "label" => "Ver clientes", "level" => 1],
                ["name" => "CREATE_CUSTOMER", "label" => "Crear clientes", "level" => 2],
                ["name" => "EDIT_CUSTOMER", "label" => "Editar clientes", "level" => 2],
                ["name" => "DELETE_CUSTOMER", "label" => "Eliminar clientes", "level" => 2],
            ],
            "Reservas" => [
                ["name" => "VIEW_RESERVATION", "label" => "Ver reservas", "level" => 1],
                ["name" => "CREATE_RESERVATION", "label" => "Crear reservas", "level" => 2],
                ["name" => "EDIT_RESERVATION", "label" => "Editar reservas", "level" => 2],
                ["name" => "DELETE_RESERVATION", "label" => "Eliminar reservas", "level" => 2],
                ["name" => "MANAGE_PAYMENTS_DATES", "label" => "Administrar pagos programados", "level" => 3],
                ['name' => 'VIEW_PAYMENTS', 'label' => 'Ver pagos realizados', 'level' => 3],
                ['name' => 'MANAGE_PAYMENTS', 'label' => 'Registrar pagos de cliente', 'level' => 4],
                ['name' => 'MANAGE_RESERVATION_SERVICES', 'label' => 'Administrar servicios de una reserva', 'level' => 4],
                ['name' => 'REQUEST_SERVICE_SETTLEMENT', 'label' => 'Solicitar liquidación de servicio con Transferencia/Monedero virtual', 'level' => 4],
                ['name' => 'AUTHORIZE_SERVICE_SETTLEMENT', 'label' => 'Autorizar servicio de liquidación con transferencia/monedero virtual', 'level' => 4],
                ['name' => 'CREATE_SERVICE_SETTLEMENT_WITH_CARD', 'label' => 'Liquidar servicio con tarjeta de crédito', 'level' => 4],
            ]
        ];
        DB::table('module_permissions')->truncate();
        DB::table('modules')->truncate();

        foreach ($modules as $name => $permissions) {
            $m = new \App\Models\Module();
            $m->name = $name;
            $m->save();
            foreach ($permissions as $permission) {
                $mp = new \App\Models\ModulePermission();
                $mp->name = $permission['name'];
                $mp->label = $permission['label'];
                $mp->level = $permission['level'];
                $mp->module_id = $m->id;
                $mp->save();
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
