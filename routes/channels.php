<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userOneId}.{userTwoId}', function ($user, $userOneId, $userTwoId) {
    $ids = [(int) $userOneId, (int) $userTwoId];
    sort($ids); // Ordena os IDs para garantir o mesmo canal para ambas as partes

    return in_array($user->id, $ids); // Permite acesso se o usuário é um dos participantes
});
