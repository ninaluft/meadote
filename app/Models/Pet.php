<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'photo_path',
        'species',
        'specify_other',
        'gender',
        'age',
        'size',
        'is_neutered',
        'special_conditions',
        'special_conditions_description',
        'description',
        'status',
        'user_id',
    ];

    /**
     * O pet pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento para o favorito.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * Relacionamento para os formulários de adoção.
     */
    public function adoptionForms()
    {
        return $this->hasMany(AdoptionForm::class);
    }



    public function adoptedForms()
{
    return $this->adoptionForms()->where('status', 'approved');
}

}