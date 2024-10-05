<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class OngEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'ong_id',
        'title',
        'description',
        'event_date',
        'city',
        'state',
        'cep',
        'location',
        'photo_path'
    ];

    public function ong()
    {
        return $this->belongsTo(Ong::class);
    }


}
