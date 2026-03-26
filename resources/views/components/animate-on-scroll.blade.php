@props(['animation' => 'fade-in-up', 'tag' => 'div'])

<{{ $tag }}
    x-data="{ shown: false }"
    x-intersect="shown = true"
    :class="{
        'opacity-0': !shown,
        'opacity-100 animate-{{ $animation }}': shown
    }"
    {{ $attributes->merge(['class' => 'transition-all duration-500']) }}
>
    {{ $slot }}
</{{ $tag }}>
