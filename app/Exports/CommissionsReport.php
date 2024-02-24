<?php

namespace App\Exports;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommissionsReport implements FromCollection {
    protected $result;
    public function __construct(Request $request)
    {

        $users = User::with([]);

        if($request->filled('ids')){
            $users = User::whereIn('id', $request->input('ids'));
        }

        $users->with(['reservation_details' => function($q) use ($request) {
            $q->whereNull('cancelled_at')
                ->when($request->filled('start_date') && $request->filled('end_date'), function($q) use ($request) {
                    $q->whereBetween('created_at',[date('Y-m-d', strtotime($request->input('start_date'))), date('Y-m-d', strtotime($request->input('end_date')))]);
                });
        }]);

        $users = $users->get();

        $excel_array = [
            [
                'USUARIO',
                'TOTAL DE COMISIÓN'
            ]
        ];

        foreach ($users as $user) {
            $excel_array[] = [
                //USUARIO
                $user->username,
                //TOTAL DE COMISIÓN
                $user->reservation_details->sum('agent_commission')
            ];
        }

        $this->result = $excel_array;
    }

    public function collection()
    {
        return new Collection($this->result);
    }
}
