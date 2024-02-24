<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserCommissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->integer('hotels_commission')->default(0);
            $table->integer('tours_commission')->default(0);
            $table->integer('car_rentals_commission')->default(0);
            $table->integer('pickups_commission')->default(0);
            $table->integer('flights_commission')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
