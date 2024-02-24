<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CustomerAndLeadsChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table){
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->after('name', function($table){
                $table->string('last_name')->nullable();
            });
            $table->renameColumn('name', 'first_name');
            $table->boolean('is_agency')->nullable()->change();
            $table->boolean('is_mini_vacs')->nullable()->change();
        });
        Schema::table('customers', function (Blueprint $table){
            $table->date('birthday')->nullable()->change();
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
