<style>
    .page-slider {
        overflow: visible !important;
    }

    .page-slider .swiper-slide {
        height: auto !important;
    }

    .page-slider-wrapper {
        margin-right: -100vw;
        padding-right: 100vw;
        overflow: hidden; /* Обрезает клоны слева, но позволяет слайдеру "уходить" вправо */
    }

    /* Внешний контейнер теперь просто предотвращает горизонтальный скролл на странице */
    .slider-external-container {
        width: auto;
    }

    /* Линейная анимация для плавного движения без остановок */
    .page-slider .swiper-wrapper {
        transition-timing-function: linear !important;
    }
</style>

{{-- Глобальное исправление горизонтального скролла для всей страницы --}}
@push('scripts')
<style>
    html, body {
        overflow-x: hidden;
        max-width: 100%;
    }
</style>
@endpush
<div class="my-10 slider-external-container">
    <div class="page-slider-wrapper">
        <div class="page-slider">
            <div class="swiper-wrapper flex items-stretch mb-10">
                @foreach ($slides as $item)
                    <div class="swiper-slide rounded-2xl bg-[#F0F2F5] p-9 h-auto flex flex-col">
                        @if (isset($item['title']))
                            <p class="font-inter-regular font-medium text-[64px] !text-[#535B5E]">{{ $item['title'] }}</p>
                        @endif
                        <div class="flex-1 !font-inter-medium">
                            {!! $item['text'] !!}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center space-x-2 max-w-fit mx-auto rounded-3xl bg-secondary p-2">
                <div
                    class="ad-swiper-button-prev  p-1 bg-white rounded-full text-gray-700 cursor-pointer !disabled:opacity-50">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.7071 4.29289C16.0976 4.68342 16.0976 5.31658 15.7071 5.70711L9.41421 12L15.7071 18.2929C16.0976 18.6834 16.0976 19.3166 15.7071 19.7071C15.3166 20.0976 14.6834 20.0976 14.2929 19.7071L7.29289 12.7071C7.10536 12.5196 7 12.2652 7 12C7 11.7348 7.10536 11.4804 7.29289 11.2929L14.2929 4.29289C14.6834 3.90237 15.3166 3.90237 15.7071 4.29289Z"
                            fill="#000000" />
                    </svg>
                </div>
                <div
                    class="ad-swiper-button-next p-1 bg-white rounded-full text-gray-700 cursor-pointer !disabled:opacity-50">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.29289 4.29289C8.68342 3.90237 9.31658 3.90237 9.70711 4.29289L16.7071 11.2929C17.0976 11.6834 17.0976 12.3166 16.7071 12.7071L9.70711 19.7071C9.31658 20.0976 8.68342 20.0976 8.29289 19.7071C7.90237 19.3166 7.90237 18.6834 8.29289 18.2929L14.5858 12L8.29289 5.70711C7.90237 5.31658 7.90237 4.68342 8.29289 4.29289Z"
                            fill="#000000" />
                    </svg>
                </div>
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
        document.querySelectorAll('.page-slider').forEach(function (el) {
            const swiper = new Swiper(el, {
                spaceBetween: 20,
                centeredSlides: false,
                loop: true,
                speed: 8000, // Скорость движения (чем выше, тем медленнее)
                autoplay: {
                    delay: 0,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: el.querySelector('.ad-swiper-button-next'),
                    prevEl: el.querySelector('.ad-swiper-button-prev'),
                },
                mousewheel: {
                    releaseOnEdges: true,
                },
                breakpoints: {
                    480: {
                        slidesPerView: 1
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    }
                }
            });

            // Останавливаем автопрокрутку по умолчанию
            swiper.autoplay.stop();

            // Запускаем автопрокрутку только при наведении
            el.addEventListener('mouseenter', function () {
                // Сначала восстанавливаем настройки перехода
                swiper.setTransition(8000);
                swiper.autoplay.start();
                // Обновляем состояние и форсируем движение к следующему реальному индексу
                swiper.update();
                swiper.slideToLoop(swiper.realIndex + 1, 8000);
            });

            // Мгновенная остановка при уходе курсора
            el.addEventListener('mouseleave', function () {
                swiper.autoplay.stop();

                // Моментально фиксируем текущее положение
                const currentTranslate = swiper.getTranslate();
                swiper.setTransition(0);
                swiper.setTranslate(currentTranslate);
            });
        });
    </script>
@endpush