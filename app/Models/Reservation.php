<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $appends = ['status'];
    protected $casts = [
        'editable' => 'boolean',
        'cancelable' => 'boolean',
        'with_payments' => 'boolean',
        'paid_to_provider' => 'boolean',
    ];

    public static $permissions = [
        'view' => 'VIEW_RESERVATION',
        'create' => 'VIEW_RESERVATION',
        'edit' => 'EDIT_RESERVATION',
        'delete' => 'DELETE_RESERVATION',
    ];

    public function getStatusAttribute()
    {
        $current_payments = $this->reservation_payments()->where('cancelled_at', null)->get();
        $totalPaid = $current_payments->sum(function ($payment) {
            return $payment->amount;
        });

        /*
         * 0 es cancelada
         * 1 es pendiente de pago
         * 2 es pagado
         */
        $count = $this->reservation_details()->where('cancelled_at', null)->count();
        if ($count === 0) {
            return 0;
        }
        return $totalPaid < $this->public_price ? 1 : 2;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cancelled_by()
    {
        return $this->belongsTo(User::class, 'cancelled_by_id');
    }

    public function edited_by()
    {
        return $this->belongsTo(User::class, 'edited_by_id');
    }

    public function reservation_details()
    {
        return $this->hasMany(ReservationDetail::class);
    }

    public function reservation_payment_dates()
    {
        return $this->hasMany(ReservationPaymentDate::class);
    }

    public function reservation_payments()
    {
        return $this->hasMany(ReservationPayment::class);
    }

    public function reservation_comments()
    {
        return $this->hasMany(ReservationComment::class);
    }

    public function wallets()
    {
        return $this->hasManyThrough(CustomerWallet::class, ReservationDetail::class);
    }

}
