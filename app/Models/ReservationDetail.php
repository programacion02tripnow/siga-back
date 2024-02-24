<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'cancellable' => 'boolean',
        'editable' => 'boolean',
        'refundable' => 'boolean',
    ];

    protected $need_ages = [
        // HotelReservation::class,
        TourReservation::class,
    ];

    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reservable(){
        return $this->morphTo();
    }

    public function provider(){
        return $this->belongsTo(Provider::class);
    }

    public function cancelled_by(){
        return $this->belongsTo(User::class, 'cancelled_by_id');
    }

    public function reservation_detail_comments(){
        return $this->hasMany(ReservationDetailComment::class);
    }
    public function reservation_detail_ages(){
        return $this->hasMany(ReservationDetailAge::class);
    }

    public function detail_needs_ages(){
        return in_array($this->reservable_type, $this->need_ages);
    }

    public function settlement(){
        return $this->hasOne(Settlement::class);
    }

    public function multimedia(){
        return $this->belongsTo(Multimedia::class);
    }

    public function customer_wallet(){
        return $this->hasOne(CustomerWallet::class);
    }
}
