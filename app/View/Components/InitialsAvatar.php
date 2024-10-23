<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InitialsAvatar extends Component
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('components.initials-avatar');
    }

    public function getInitials()
    {
        if ($this->user->user_type === 'ong' || $this->user->user_type === 'admin') {
            $ongName = $this->user->ong->ong_name ?? 'Informação';
            return strtoupper(substr($ongName, 0, 1)) . strtoupper(substr(explode(' ', $ongName)[1] ?? '', 0, 1));
        } elseif ($this->user->user_type === 'tutor') {
            $fullName = $this->user->tutor->full_name ?? 'Informação';
            return strtoupper(substr($fullName, 0, 1)) . strtoupper(substr(explode(' ', $fullName)[1] ?? '', 0, 1));
        } else {
            $firstName = $this->user->name;
            $lastName = $this->user->last_name ?? $firstName;
            return strtoupper(substr($firstName, 0, 1)) . strtoupper(substr(explode(' ', $lastName)[1] ?? '', 0, 1));
        }
    }
}
