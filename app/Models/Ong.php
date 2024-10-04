<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ong extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ong_name',
        'phone',
        'responsible_name',
        'responsible_cpf',
        'cnpj',
        'about_ong',
    ];

    /**
     * A ONG pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
