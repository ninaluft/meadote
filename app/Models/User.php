<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'cep',
        'city',
        'state',
        'profile_photo',
        'profile_photo_public_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo',
    ];

    /**
     * Get the pets for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Pet::class, 'favorites')->withTimestamps();
    }

    public function hasFavorited(Pet $pet)
    {
        return $this->favorites()->where('pet_id', $pet->id)->exists();
    }



    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }


    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id')->where('is_read', false);
    }

    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }

    public function ong()
    {
        return $this->hasOne(Ong::class);
    }


    // Mensagens de suporte recebidas pelo administrador
    public function receivedSupportMessages()
    {
        return $this->hasMany(SupportMessage::class, 'admin_id');
    }


    // Relacionamento com solicitações de suporte
    public function supportRequests()
    {
        return $this->hasMany(SupportRequest::class);
    }

    // Relacionamento com mensagens de suporte
    public function supportMessages()
    {
        return $this->hasMany(SupportMessage::class);
    }

    public function adoptionForms()
    {
        return $this->hasMany(AdoptionForm::class, 'submitter_user_id'); // Relacionamento com o campo correto
    }

    public function receivedAdoptionForms()
    {
        return $this->hasMany(AdoptionForm::class, 'responsible_user_id');
    }

    public function ongEvents()
    {
        return $this->hasManyThrough(OngEvent::class, Ong::class, 'user_id', 'ong_id', 'id', 'id');
    }

    public function adoptionFormsSent()
    {
        return $this->hasMany(AdoptionForm::class, 'submitter_user_id');
    }

    public function adoptionFormsReceived()
    {
        return $this->hasMany(AdoptionForm::class, 'responsible_user_id');
    }

    public function socialNetworks()
    {
        return $this->hasMany(SocialNetwork::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function getProfilePhotoAttribute()
    {
        return $this->attributes['profile_photo'] ?? asset('images/default-profile.jpg');
    }
}
