<div class="my-10">

    <div class="flex rounded-3xl overflow-hidden shadow-md">
        <div class="hidden md:block w-3/5">

            <div class="swiper {{ $id }}  relative overflow-hidden h-full">
                <div class="swiper-wrapper items-stretch">
                    @foreach ($images as $image)
                        <div class="swiper-slide h-auto overflow-hidden shadow-lg">
                            <img class="w-full !h-full object-cover margin-0 border-none"
                                style="margin:0 !important; border-radius: 0;" src="/storage/{{ $image['image'] }}"
                                alt="slide">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination {{ $id }}-pagination shadow-md m-auto"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
        <div class="w-full lg:w-2/5 bg-secondary p-10">
            <h1 class="font-inter text-4xl my-5">{{$title}}</h1>
            <div class="text-sf font-medium !text-xl leading-tight mb-6">{!! $description !!}</div>

            @foreach ($buttons as $button)
                @if ($button['button_title'])
                    <a href="{{ $button['button_link'] ?: '/storage/' . (string) $button['button_file'] }}"
                        class="inline-block bg-rich-primary text-white rounded-3xl text-lg px-8 py-2 mb-3 hover:bg-white hover:text-rich-primary border border-primary"
                        style="text-decoration-line: none;" target="_blank">{{ $button['button_title'] }}</a>
                @endif
            @endforeach
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script src="{{ asset('/js/swiper-bundle.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        new Swiper('.{{ $id }}', {
            spaceBetween: 20,
            centeredSlides: true,
            loop: true,
            pagination: {
                el: '.{{ $id }}-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            slidesPerView: 1
        });
    </script>
@endpush