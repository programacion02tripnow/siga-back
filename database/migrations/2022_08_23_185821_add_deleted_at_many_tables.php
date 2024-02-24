<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtManyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('reservation_payments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reservation_payment_dates', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reservation_comments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reservation_details', function (Blueprint $table) {
            $table->softDeletes();
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
