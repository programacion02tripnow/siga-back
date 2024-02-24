<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadChannel extends Model
{
    use HasFactory;

    public static $permissions = [
        'view' => 'MANAGE_LEAD_CHANNELS',
        'create' => 'MANAGE_LEAD_CHANNELS',
        'edit' => 'MANAGE_LEAD_CHANNELS',
        'delete' => 'MANAGE_LEAD_CHANNELS',
    ];

    public function leads(){
        return $this->hasMany(Lead::class);
    }
}
