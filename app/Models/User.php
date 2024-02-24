<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $appends = ['ability'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $permissions = [
        'view' => 'VIEW_USER',
        'create' => 'CREATE_USER',
        'edit' => 'EDIT_USER',
        'delete' => 'DELETE_USER',
    ];

    public static function getHasPermission($permission)
    {
        return User::whereHas('role', function ($query) use ($permission) {
            $query->whereHas('role_permissions', function ($query) use ($permission) {
                $query->whereHas('module_permission', function ($query) use ($permission) {
                    $query->where('name', $permission);
                });
            });
        })->orWhereDoesntHave('role')->get();
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function hasPermission($permission)
    {
        return !$this->role || count($this->role->role_permissions()->whereHas('module_permission', function ($q) use ($permission) {
                $q->where('name', $permission);
            })->get()) > 0;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function customer_comments()
    {
        return $this->hasMany(CustomerComment::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function cancelled_reservations()
    {
        return $this->hasMany(Reservation::class, 'cancelled_by_id');
    }

    public function cancelled_reservation_details()
    {
        return $this->hasMany(ReservationDetail::class, 'cancelled_by_id');
    }

    public function reservation_details()
    {
        return $this->hasMany(ReservationDetail::class);
    }

    public function reservation_detail_comments()
    {
        return $this->hasMany(ReservationDetailComment::class);
    }

    public function reservation_payments()
    {
        return $this->hasMany(ReservationPayment::class);
    }

    public function cancelled_reservation_payments()
    {
        return $this->hasMany(ReservationPayment::class, 'cancelled_by_id');
    }

    public function getAbilityAttribute()
    {
        $result = [];
        if ($this->role) {
            $permissions = $this->role->role_permissions()->with(['module_permission.module'])->get();
            foreach ($permissions as $permission) {
                $result[] = [
                    'action' => $permission->module_permission->name,
                    'subject' => $permission->module_permission->module->name
                ];
            }
        } else {
            $modules = Module::with('module_permissions')->get();
            foreach ($modules as $module) {
                foreach ($module->module_permissions as $module_permission) {
                    $result[] = [
                        'action' => $module_permission->name,
                        'subject' => $module->name
                    ];
                }
            }
        }

        $result[] = [
            'action' => 'read',
            'subject' => 'Auth',
        ];

        return $result;
    }

    public function payment_authentication_requests()
    {
        return $this->hasMany(PaymentAuthenticationRequest::class);
    }

    public function authorized_payment_authentication_requests()
    {
        return $this->hasMany(PaymentAuthenticationRequest::class, 'authorizing_user_id');
    }

    public function multimedia()
    {
        return $this->belongsTo(Multimedia::class);
    }

    public function general_announcements()
    {
        return $this->hasMany(GeneralAnnouncement::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function authorized_settlements()
    {
        return $this->hasMany(Settlement::class, 'authorized_user_id');
    }
}
