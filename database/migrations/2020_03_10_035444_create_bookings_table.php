<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string  ('name');
            $table->dateTime('date_time');
            $table->string  ('Ride_details');
            $table->string  ('address');
            $table->string  ('address_type');
            $table->string  ('destination');
            $table->string  ('destination_type');
            $table->decimal ('duration');
            $table->decimal ('vehicle_id');
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
        Schema::dropIfExists('bookings');
    }
}
