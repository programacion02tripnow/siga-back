<?php

use App\Models\Multimedia;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CreateMultimediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('filename', 255);
            $table->string('file_url', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('multimedia_id')->nullable()->constrained();
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->foreignId('multimedia_id')->nullable()->constrained();
        });


        Schema::table('reservation_payments', function(Blueprint $table) {
            $table->dropForeign(['reservation_id']);
            $table->foreignId('reservation_id')->nullable()->change();
            $table->foreign('reservation_id')->references('id')->on('reservations');
        });

        $m = new Multimedia();
        $m->filename = "user.png";
        $m->file_url = asset('img/' . $m->filename);
        $m->save();

        $users = \App\Models\User::all();
        foreach ($users as $user){
            $user->multimedia_id = $m->id;
            $user->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multimedia');
    }
}
