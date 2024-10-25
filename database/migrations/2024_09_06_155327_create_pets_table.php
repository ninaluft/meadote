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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('species', ['dog', 'cat', 'other']);
            $table->string('specify_other', 2048)->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->enum('age', ['puppy', 'adult', 'senior']);
            $table->enum('size', ['small', 'medium', 'large']);
            $table->boolean('is_neutered')->default(false);
            $table->boolean('special_conditions')->default(false);
            $table->text('special_conditions_description')->nullable();
            $table->text('description')->nullable();
            $table->string('photo_path', 2048)->nullable();
            $table->string('photo_public_id', 255)->nullable();
            $table->enum('status', ['available', 'adopted'])->default('available');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
