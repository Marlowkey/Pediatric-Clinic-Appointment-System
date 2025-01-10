<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('schedule_date');
            $table->unsignedBigInteger('available_time_id')->nullable(); // Nullable to allow decoupling
            $table->string('patient_name');
            $table->string('guardian_name');
            $table->string('phone_number');
            $table->text('message')->nullable();
            $table->time('start_time');
            $table->time('end_time');   
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed'])->default('pending');
            $table->timestamps();
            $table->foreign('available_time_id')->references('id')->on('available_times')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
