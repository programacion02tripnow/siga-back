<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoreTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('requires_auth');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payment_method_additional_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')->constrained();
            $table->string('name');
            $table->boolean('is_required');
            $table->tinyInteger('type'); // 1 -> texto, 2 -> archivo
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->date('birthday');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customer_phones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->string('phone', 15);
            $table->timestamps();
        });

        Schema::create('customer_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->text('comment');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->double('public_price');
            $table->double('net_price');
            $table->double('added_price')->default(0);
            $table->boolean('editable');
            $table->boolean('cancelable');
            $table->boolean('with_payments');
            $table->date('cancelled_at');
            $table->foreignId('cancelled_by_id')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('reservation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('reservable_id');// id de morph antes service_type_id
            $table->string('reservable_type'); // modelo de morph antes service_type_class
            $table->double('public_price')->nullable();
            $table->double('net_price')->nullable();
            $table->double('added_price')->default(0);
            $table->foreignId('provider_id')->constrained();
            $table->boolean('cancellable');
            $table->boolean('editable');
            $table->boolean('refundable');
            $table->text('terms_conditions')->nullable();
            $table->date('cancelled_at')->nullable();
            $table->foreignId('cancelled_by_id')->nullable()->constrained('users');
            $table->string('provider_confirmation_number')->nullable();
            $table->index('provider_confirmation_number');
            $table->timestamps();
        });

        Schema::create('hotel_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('destination');
            $table->string('hotel_name');
            $table->string('hotel_phone')->nullable();
            $table->double('resort_rate')->nullable();
            $table->double('sanitation_rate')->nullable();
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->integer('adults_quantity');
            $table->integer('minors_quantity');
            $table->string('meal_plan');
            $table->boolean('is_pack');
            $table->timestamps();
        });

        Schema::create('reservation_detail_ages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_detail_id')->constrained();
            $table->integer('age');
            $table->timestamps();
        });

        Schema::create('hotel_reservation_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_reservation_id')->constrained();
            $table->string('room_type');
            $table->double('public_price')->nullable();
            $table->double('net_price')->nullable();
            $table->text('special_request')->nullable();
            $table->timestamps();
        });

        Schema::create('flight_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('airline');
            $table->string('PNR');
            $table->boolean('round');
            $table->integer('adults_quantity');
            $table->integer('minors_quantity');
            $table->text('migration_text')->nullable();
            $table->text('general_notes')->nullable();
            $table->text('international_flight_text')->nullable();
            $table->text('national_flight_text')->nullable();
            $table->boolean('is_pack');
            $table->timestamps();
        });

        Schema::create('flight_reservation_people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_reservation_id')->constrained();
            $table->string('full_name');
            $table->integer('age');
            $table->timestamps();
        });

        Schema::create('flight_reservation_flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_reservation_id')->constrained();
            $table->tinyInteger('type');// 1 -> ida, 2 ->vuelta, 3->escala
            $table->string('departure_city');
            $table->string('departure_airport');
            $table->dateTime('departure_datetime');
            $table->string('arrive_city');
            $table->string('arrive_airport');
            $table->dateTime('arrive_datetime');
            $table->double('public_price')->nullable();
            $table->double('net_price')->nullable();
            $table->double('added_price')->default(0);
            $table->timestamps();
        });

        Schema::create('flight_reservation_flight_addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flight_reservation_flight_id');//->constrained();
            $table->string('name');
            $table->integer('quantity');
            $table->double('public_price')->nullable();
            $table->double('net_price')->nullable();
            $table->timestamps();

            $table->foreign('flight_reservation_flight_id', 'flights_to_addons')->references('id')->on('flight_reservation_flights');
        });

        Schema::create('flight_reservation_flight_additional_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flight_reservation_flight_id');//->constrained();
            $table->string('name');
            $table->timestamps();

            $table->foreign('flight_reservation_flight_id', 'flights_to_additional_services')->references('id')->on('flight_reservation_flights');
        });

        Schema::create('tour_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('destination');
            $table->string('tour_name');
            $table->string('package_name')->nullable();
            $table->date('date');
            $table->integer('adults_quantity');
            $table->integer('minors_quantity');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('pickup_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('destination');
            $table->string('pickup', 500);
            $table->text('pickup_comment');
            $table->dateTime('datetime');
            $table->integer('adults_quantity');
            $table->integer('minors_quantity');
            $table->integer('type'); // 1 -> privado, 2 -> compartido
            $table->string('transportation_type');
            $table->text('provider_notes');
            $table->timestamps();
        });

        Schema::create('car_rental_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('pickup');
            $table->dateTime('datetime_pickup');
            $table->dateTime('return_datetime');
            $table->string('return');
            $table->string('agency_name');
            $table->string('car_category');
            $table->boolean('insurance');
            $table->text('recommendations');
            $table->timestamps();
        });

        Schema::create('car_rental_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_rental_reservation_id')->constrained();
            $table->string('name');
            $table->double('public_price')->nullable();
            $table->double('net_price')->nullable();
            $table->timestamps();
        });

        Schema::create('reservation_detail_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_detail_id')->constrained();
            $table->text('comment');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });

        Schema::create('reservation_payment_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained();
            $table->double('amount');
            $table->date('date');
            $table->timestamps();
        });

        Schema::create('reservation_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained();
            $table->double('amount');
            $table->date('date');
            $table->foreignId('payment_method_id')->nullable()->constrained();
            $table->text('payment_method_text')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->date('cancelled_at')->nullable();
            $table->foreignId('cancelled_by_id')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('reservation_payment_additional_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_payment_id');//->constrained();
            $table->unsignedBigInteger('payment_method_additional_field_id');//->constrained();
            $table->string('value');
            $table->timestamps();

            $table->foreign('reservation_payment_id', 'reservation_payment_to_additional_values')->references('id')->on('reservation_payments');
            $table->foreign('payment_method_additional_field_id', 'additional_fields_to_reservation_payment')->references('id')->on('payment_method_additional_fields');
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
