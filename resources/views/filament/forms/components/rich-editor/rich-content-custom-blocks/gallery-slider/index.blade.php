<div class="my-10">
    <div class="overflow-hidden page-slider">
        <div class="swiper-wrapper flex items-stretch mb-10">
            @foreach ($images as $image)
                <div class="swiper-slide rounded-2xl overflow-hidden shadow-lg"
                    style="height: {{ $height ?? 400 }}px !important;">
                    <img class="block w-full object-cover" src="/storage/{{ $image['image'] }}" alt="slide"
                        style="height: 100% !important;">
                </div>
            @endforeach
        </div>
        <div class="flex justify-center space-x-2 max-w-fit mx-auto rounded-3xl bg-secondary p-2">
            <div class="ad-swiper-button-prev p-1 bg-white rounded-full text-gray-700 cursor-pointer">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M15.7071 4.29289C16.0976 4.68342 16.0976 5.31658 15.7071 5.70711L9.41421 12L15.7071 18.2929C16.0976 18.6834 16.0976 19.3166 15.7071 19.7071C15.3166 20.0976 14.6834 20.0976 14.2929 19.7071L7.29289 12.7071C7.10536 12.5196 7 12.2652 7 12C7 11.7348 7.10536 11.4804 7.29289 11.2929L14.2929 4.29289C14.6834 3.90237 15.3166 3.90237 15.7071 4.29289Z"
                        fill="#000000" />
                </svg>
            </div>
            <div class="ad-swiper-button-next p-1 bg-white rounded-full text-gray-700 cursor-pointer">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.29289 4.29289C8.68342 3.90237 9.31658 3.90237 9.70711 4.29289L16.7071 11.2929C17.0976 11.6834 17.0976 12.3166 16.7071 12.7071L9.70711 19.7071C9.31658 20.0976 8.68342 20.0976 8.29289 19.7071C7.90237 19.3166 7.90237 18.6834 8.29289 18.2929L14.5858 12L8.29289 5.70711C7.90237 5.31658 7.90237 4.68342 8.29289 4.29289Z"
                        fill="#000000" />
                </svg>
            </div>
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
        let slidesPerView = @json($slidesPerView);
        console.log(typeof slidesPerView);
        var swiperSlide = new Swiper('.page-slider', {
            spaceBetween: 20,
            centeredSlides: true,
            loop: true,
            navigation: {
                nextEl: '.ad-swiper-button-next',
                prevEl: '.ad-swiper-button-prev',
            },
            breakpoints: {
                480: {
                    slidesPerView: 1
                },
                1200: {
                    slidesPerView: slidesPerView ? slidesPerView : 1.7,
                    spaceBetween: 30
                }
            }
        });

    </script>
@endpush