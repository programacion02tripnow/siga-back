<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationComment extends \Illuminate\Database\Eloquent\Model
{
    use SoftDeletes;

    function reservation(){
        return $this->belongsTo(Reservation::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }

}
