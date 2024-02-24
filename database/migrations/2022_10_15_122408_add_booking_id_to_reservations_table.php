<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingIdToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
            $table->string('booking_id')->nullable();
            $table->unsignedBigInteger('edited_by_id')->nullable();
        });

        $reservations = \App\Models\Reservation::all();
        foreach ($reservations as $reservation) {
            $reservation->booking_id = strtoupper(bin2hex(random_bytes(2))) . '-' . $reservation->id;
            $reservation->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
        });
    }
}
