<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'user_id',
        'date_of_birth',
        'cpf',
        'temporary_housing',
        'about_me',
    ];

    /**
     * O tutor pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
