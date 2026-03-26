<div class="overflow-hidden partner-slider"
     x-cloak
     x-data="{ show: false }"
     x-init="setTimeout(() => show = true, 40)"
     x-show="show"
     x-transition:enter="transition ease-out duration-600"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100">

    <div class="swiper-wrapper flex items-center">
        @foreach ($partners as $partner)
            <div class="swiper-slide p-2">
                @if ($partner->link)
                    <a href="{{ $partner->link }}" target="_blank">
                        <img class="block w-full object-cover p-8" src="{{ $partner->getLogo() }}" alt="partner">
                    </a>
                @else
                    <img class="block w-full object-cover p-8" src="{{ $partner->getLogo() }}" alt="partner">
                @endif
            </div>
        @endforeach
    </div>
</div>

