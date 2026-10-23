@if (filled($title) || filled($description))
    <header class="nis-recognition-map__header">
        @if (filled($title))
            <h2 class="nis-recognition-map__title">{{ $title }}</h2>
        @endif
        @if (filled($description))
            <p class="nis-recognition-map__intro">{{ $description }}</p>
        @endif
    </header>
@endif
<div class="nis-recognition-map__stats">
    @foreach (['total' => $total, 'countries' => $foreignCountries] as $label => $value)
        <div class="nis-recognition-map__stat">
            <strong>{{ number_format($value, 0, '.', ' ') }}</strong>
            <span>{{ __('recognition-map.' . $label) }}</span>
        </div>
    @endforeach
</div>
