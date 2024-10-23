@props(['user', 'class' => 'h-40 w-40']) <!-- Define um valor padrão, mas permite sobrescrever -->

<!-- Aqui você ajusta o layout do avatar -->
<span class="inline-flex items-center justify-center rounded-full bg-gray-500 {{ $class }}"
      aria-label="Imagem de perfil indisponível, mostrando iniciais de {{ $user->name }}">
    <span class="text-lg font-medium leading-none text-white">
        @if ($user->user_type === 'ong' || $user->user_type === 'admin')
            {{ strtoupper(substr($user->ong->ong_name ?? 'Informação', 0, 1)) }}
            {{ strtoupper(substr(explode(' ', $user->ong->ong_name ?? 'Informação')[1] ?? '', 0, 1)) }}
        @elseif ($user->user_type === 'tutor')
            {{ strtoupper(substr($user->tutor->full_name ?? 'Informação', 0, 1)) }}
            {{ strtoupper(substr(explode(' ', $user->tutor->full_name ?? 'Informação')[1] ?? '', 0, 1)) }}
        @else
            {{ strtoupper(substr($user->name, 0, 1)) }}
            {{ strtoupper(substr(explode(' ', $user->last_name ?? $user->name)[1] ?? '', 0, 1)) }}
        @endif
    </span>
</span>
