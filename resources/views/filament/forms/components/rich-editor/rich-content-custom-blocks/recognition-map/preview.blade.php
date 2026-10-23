<div class="nis-recognition-map nis-recognition-map--preview not-prose">
    @include('filament.forms.components.rich-editor.rich-content-custom-blocks.recognition-map.summary')
    <img class="nis-recognition-map__preview-image" src="{{ asset('img/recognition-world-map.svg') }}" alt="{{ __('recognition-map.map') }}" width="1100" height="450">
    <div class="nis-recognition-map__filters">
        @forelse ($countries as $country)
            <span class="nis-recognition-map__chip">{{ $country['name'] }} <span>{{ $country['count'] }}</span></span>
        @empty
            <span>{{ __('recognition-map.no_countries') }}</span>
        @endforelse
    </div>
</div>
