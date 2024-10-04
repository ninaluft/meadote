<?php

namespace App\Policies;

use App\Models\SupportMessage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupportMessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any support messages.
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the support message.
     */
    public function view(User $user, SupportMessage $supportMessage)
    {
        return $user->isAdmin() || $user->id === $supportMessage->user_id;
    }

    /**
     * Determine whether the user can update the support message.
     */
    public function update(User $user, SupportMessage $supportMessage)
    {
        return $user->isAdmin();
    }

    // Outros métodos como create, delete podem ser adicionados conforme necessário
}
