<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    use HasFactory;

    protected $casts = [
        'cancelled_status' => 'boolean'
    ];

    public static $permissions = [
        'view' => 'MANAGE_LEAD_STATUSES',
        'create' => 'MANAGE_LEAD_STATUSES',
        'edit' => 'MANAGE_LEAD_STATUSES',
        'delete' => 'MANAGE_LEAD_STATUSES',
    ];

    public function leads(){
        return $this->hasMany(Lead::class);
    }
}
