<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $fillable = ['user_id', 'platform_name', 'profile_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
