<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelReservationRoomPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_reservation_room_people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_reservation_room_id')->constrained();
            // $table->string('full_name');
            $table->integer('age');
            $table->timestamps();
        });

        Schema::table('hotel_reservation_rooms', function (Blueprint $table) {
            $table->integer('adults_quantity');
            $table->integer('minors_quantity');
        });

        Schema::table('hotel_reservations', function (Blueprint $table) {
            $table->dropColumn('adults_quantity');
            $table->dropColumn('minors_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_reservation_room_people');
    }
}
