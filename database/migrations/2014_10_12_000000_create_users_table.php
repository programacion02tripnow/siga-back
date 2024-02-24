<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->foreignId('role_id')->nullable()->constrained();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone', 15)->nullable();
            $table->date('birthday')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        $user = new \App\Models\User();
        $user->username = 'jtzuc@dcitdev.com';
        $user->password = bcrypt('secret');
        $user->save();



        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lead_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color', 10);
            $table->tinyInteger('order');
            $table->boolean('cancelled_status')->default(false);
            $table->timestamps();
        });

        Schema::create('lead_channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->boolean('is_agency');
            $table->boolean('is_mini_vacs');
            $table->foreignId('lead_channel_id')->constrained();
            $table->string('campaign');
            $table->string('destination');
            $table->date('desirable_date');
            $table->foreignId('lead_status_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('module_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->integer('level');
            $table->foreignId('module_id')->constrained();
            $table->timestamps();
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained();
            $table->foreignId('module_permission_id')->constrained();
            $table->timestamps();
        });

        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('logable_type');
            $table->foreignId('logable_id');
            $table->text('log');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
