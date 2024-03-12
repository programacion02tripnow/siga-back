<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'is_agency' => 'boolean',
        'is_mini_vacs' => 'boolean',
    ];

    public static $permissions = [
        'view' => 'VIEW_LEAD',
        'create' => 'EDIT_LEAD',
        'edit' => 'EDIT_LEAD',
        'delete' => 'DELETE_LEAD',
    ];

    public function lead_channel()
    {
        return $this->belongsTo(LeadChannel::class);
    }

    public function lead_status()
    {
        return $this->belongsTo(LeadStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->morphOne(Log::class, 'logable');
    }

    public function lead_comments()
    {
        return $this->hasMany(LeadComment::class);
    }
}
