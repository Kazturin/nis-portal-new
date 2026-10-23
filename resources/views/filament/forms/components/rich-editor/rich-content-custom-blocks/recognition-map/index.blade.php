@once
    <script src="{{ asset('js/components/recognition-map.js') }}" defer></script>
@endonce

<section class="nis-recognition-map not-prose"
    x-data="nisRecognitionMap({{ \Illuminate\Support\Js::from($countries) }}, {{ \Illuminate\Support\Js::from(app()->getLocale()) }})"
    aria-label="{{ __('recognition-map.map') }}">
    @include('filament.forms.components.rich-editor.rich-content-custom-blocks.recognition-map.summary')

    <div class="nis-recognition-map__panel">
        <div class="nis-recognition-map__scroll" tabindex="0" aria-label="{{ __('recognition-map.scroll') }}">
            <div class="nis-recognition-map__canvas" x-ref="map">
                <img class="nis-recognition-map__image" src="{{ asset('img/recognition-world-map.svg') }}" alt="" width="1100" height="450">
                <template x-for="country in positionedCountries" :key="country.code">
                    <button type="button" class="nis-recognition-map__marker"
                        :class="{ 'is-muted': !matchesCountry(country), 'is-selected': filter === country.code }"
                        :style="`left:${country.left}px;top:${country.top}px;--marker-size:${country.size}px`"
                        :aria-label="`${country.name}: ${format(country.count)}`" :title="country.name"
                        :aria-pressed="filter === country.code" @click="selectCountry(country.code)"
                        x-text="format(country.count)"></button>
                </template>
            </div>
        </div>
        <div class="nis-recognition-map__legend">
            <span><i class="nis-recognition-map__dot" aria-hidden="true"></i>{{ __('recognition-map.universities') }}</span>
            <span>{{ __('recognition-map.legend') }}</span>
        </div>
    </div>

    @if (count($countries))
        <div class="nis-recognition-map__controls">
            <div class="nis-recognition-map__filters" role="group" aria-label="{{ __('recognition-map.filters') }}">
                <button type="button" class="nis-recognition-map__chip" :class="{ 'is-active': filter === 'all' }"
                    :aria-pressed="filter === 'all'" @click="filter = 'all'">{{ __('recognition-map.all') }} <span>{{ $total }}</span></button>
                @foreach ($countries as $country)
                    <button type="button" class="nis-recognition-map__chip"
                        :class="{ 'is-active': filter === @js($country['code']) }"
                        :aria-pressed="filter === @js($country['code'])" @click="filter = @js($country['code'])">
                        {{ $country['name'] }} <span>{{ $country['count'] }}</span>
                    </button>
                @endforeach
            </div>
            <label class="nis-recognition-map__search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5" /><path d="m16 16 4 4" /></svg>
                <span class="nis-recognition-map__sr-only">{{ __('recognition-map.search') }}</span>
                <input type="search" x-model.debounce.200ms="query" placeholder="{{ __('recognition-map.search') }}">
            </label>
        </div>

        <div class="nis-recognition-map__results" x-ref="results" tabindex="-1" aria-label="{{ __('recognition-map.universities') }}" aria-live="polite">
            <template x-for="item in filteredInstitutions" :key="item.key">
                <button type="button" class="nis-recognition-map__institution" :disabled="!item.url" @click="openInstitution(item)">
                    <span class="nis-recognition-map__logo">
                        <template x-if="item.logo"><img :src="item.logo" alt="" loading="lazy" x-on:error="item.logo = ''"></template>
                        <span x-show="!item.logo" aria-hidden="true" x-text="item.name.substring(0, 1)"></span>
                    </span>
                    <span class="nis-recognition-map__institution-country" x-text="item.countryName"></span>
                    <span class="nis-recognition-map__institution-name" x-text="item.name"></span>
                    <span class="nis-recognition-map__details" x-show="item.url">{{ __('recognition-map.details') }} <span aria-hidden="true">↗</span></span>
                </button>
            </template>
            <div class="nis-recognition-map__empty" x-cloak x-show="!filteredInstitutions.length">
                <p>{{ __('recognition-map.empty') }}</p>
                <button type="button" class="nis-recognition-map__reset" @click="filter = 'all'; query = ''">{{ __('recognition-map.reset') }}</button>
            </div>
        </div>
    @else
        <p class="nis-recognition-map__empty">{{ __('recognition-map.no_countries') }}</p>
    @endif

    <dialog class="nis-recognition-map__dialog" x-ref="dialog" aria-label="{{ __('recognition-map.details') }}"
        @click="$event.target === $el && $el.close()" @close="selectedInstitution = null">
        <template x-if="selectedInstitution">
            <div class="nis-recognition-map__dialog-content">
                <button type="button" class="nis-recognition-map__close" @click="$refs.dialog.close()" aria-label="{{ __('recognition-map.close') }}" autofocus>×</button>
                <template x-if="selectedInstitution.logo"><img class="nis-recognition-map__dialog-logo" :src="selectedInstitution.logo" alt=""></template>
                <span class="nis-recognition-map__eyebrow" x-text="selectedInstitution.countryName"></span>
                <h2 x-text="selectedInstitution.name"></h2>
                <dl>
                    <div x-show="selectedInstitution.year"><dt>{{ __('recognition-map.year') }}</dt><dd x-text="selectedInstitution.year"></dd></div>
                    <div x-show="selectedInstitution.basis"><dt>{{ __('recognition-map.basis') }}</dt><dd x-text="selectedInstitution.basis"></dd></div>
                </dl>
                <template x-if="selectedInstitution.url">
                    <a class="nis-recognition-map__source" :href="selectedInstitution.url" target="_blank" rel="noopener noreferrer">{{ __('recognition-map.source') }} <span aria-hidden="true">↗</span></a>
                </template>
            </div>
        </template>
    </dialog>
</section>
