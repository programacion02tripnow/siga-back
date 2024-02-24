<?php

namespace App\Imports;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Row;

class LeadsImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row){
        try{
            HeadingRowFormatter::default('none');
            $rowIndex = $row->getIndex();
            $row = $row->toArray();

            $lead = new Lead();
            $lead->name = $row['name'];
            $lead->email = $row['email'];
            $lead->phone = $row['phone'];
            $lead->is_agency = $row['is_agency'];
            $lead->is_mini_vacs = $row['is_mini_vacs'];
            $lead->lead_channel_id = $row['lead_channel_id'];
            $lead->campaign = $row['campaign'];
            $lead->destination = $row['destination'];
            $lead->desirable_date = $row['desirable_date'];
            $lead->lead_status_id = $row['lead_status_id'];
            $lead->user_id = Auth::id();
            $lead->save();

        }catch (\Exception $ex){
            dd($row, $ex);
        }
    }
}
