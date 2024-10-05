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
        Schema::create('adoption_forms', function (Blueprint $table) {
            $table->id();

            // Information about the form submitter
            $table->foreignId('submitter_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('submitter_name');

            // Information about the animal
            $table->foreignId('pet_id')->nullable()->constrained('pets')->onDelete('set null');
            $table->string('pet_name');
            $table->string('species');

            // Information about the user responsible for the animal (recipient of the form)
            $table->foreignId('responsible_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('responsible_user_name');

            // Personal Information of the Adopter (Form Submitter)
            $table->string('cpf');
            $table->date('birth_date');
            $table->string('cep');
            $table->string('city');
            $table->string('state');
            $table->string('street');
            $table->string('number');
            $table->string('complement')->nullable();
            $table->string('neighborhood');
            $table->string('phone');
            $table->string('email');
            $table->string('marital_status');
            $table->string('profession');

            // Home Information
            $table->enum('residence_type', ['house', 'apartment']);
            $table->enum('residence_ownership', ['owned', 'rented']);
            $table->boolean('outdoor_space')->default(false);
            $table->boolean('safety_measures')->default(false);
            $table->integer('number_of_residents');
            $table->boolean('has_children')->default(false);
            $table->text('children_details')->nullable();
            $table->boolean('has_other_pets')->default(false);
            $table->text('other_pets_details')->nullable();
            $table->text('other_animals_pets')->nullable();

            // Adoption Motivation and Expectations
            $table->text('adoption_reason');
            $table->boolean('long_term_commitment')->default(false);
            $table->boolean('willing_to_castrate')->default(false);
            $table->boolean('accept_future_visits')->default(false);
            $table->boolean('declaration_of_truth')->default(false);


            // Status and Additional Info
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_forms');
    }
};
