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
        Schema::create('ong_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ong_id')->constrained('ongs')->onDelete('cascade'); // The NGO organizing the event
            $table->string('title'); // Event title
            $table->text('description'); // Event description
            $table->date('event_date'); // Date of the event
            $table->time('event_time')->nullable(); // Optional: Time of the event
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('cep', 14)->nullable();
            $table->string('location'); // Location of the event (e.g., venue address)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ong_events');
    }
};
