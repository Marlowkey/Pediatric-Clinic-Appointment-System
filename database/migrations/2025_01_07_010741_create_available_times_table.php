<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('available_times', function (Blueprint $table) {
            $table->id();
            $table->time('start_time'); // Start of the time slot
            $table->time('end_time');   // End of the time slot
            $table->timestamps();
        });

        Schema::create('unavailable_time_slots', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Specific date
            $table->foreignId('available_time_id')->constrained('available_times')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['date', 'available_time_id']); // Prevent duplicate entries
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('available_times');
        Schema::dropIfExists('unavailable_time_slots');
    }
};
