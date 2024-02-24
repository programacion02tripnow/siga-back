<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            //
            $table->string('bank')->nullable();
            $table->string('business_name')->nullable();
            $table->string('RFC')->nullable();
            $table->string('clabe')->nullable();
            $table->string('notification_mail')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();

            $table->boolean('has_hotels')->default(true);
            $table->boolean('has_tours')->default(true);
            $table->boolean('has_car_rentals')->default(true);
            $table->boolean('has_pickups')->default(true);
            $table->boolean('has_flights')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            //
        });
    }
}
