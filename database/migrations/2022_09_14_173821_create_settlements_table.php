<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_detail_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('auth_token', 6)->nullable();
            $table->foreignId('authorization_user_id')->nullable()->constrained('users');
            $table->integer('settlement_method'); // 1=> Transferencia, 2=>Monedero, 3=>Tarjeta de crédito
            $table->string('last4')->nullable();
            $table->date('date');
            $table->date('authorization_date')->nullable();
            $table->timestamps();
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->double('balance')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlements');
    }
}
