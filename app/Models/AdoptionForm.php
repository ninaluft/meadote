<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionForm extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Information about the submitter
        'submitter_user_id',
        'submitter_name',

        // Information about the pet
        'pet_id',
        'pet_name',
        'species',

        // Information about the user responsible for the pet
        'responsible_user_id',
        'responsible_user_name',

        // Personal Information of the adopter (form submitter)
        'cpf',
        'birth_date',
        'cep',
        'city',
        'state',
        'street',
        'number',
        'complement',
        'neighborhood',
        'phone',
        'email',
        'marital_status',
        'profession',

        // Home Information
        'residence_type',
        'residence_ownership',
        'outdoor_space',
        'safety_measures',
        'number_of_residents',
        'has_children',
        'has_other_pets',
        'other_pets_details',

        // Adoption Motivation and Expectations
        'adoption_reason',
        'adoption_expectations',
        'long_term_commitment',
        'willing_to_sign_commitment',
        'willing_to_castrate',
        'accept_future_visits',
        'declaration_of_truth',

        // Status and additional info
        'status',
        'rejection_reason',
        'is_read',
    ];

    // Define the relationships
    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitter_user_id');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
