@props(['src', 'default' => 'images/default-profile.jpg', 'alt' => '', 'class' => ''])

<img src="{{ $src ? $src : asset($default) }}" alt="{{ $alt }}" class="{{ $class }}">
