@php($locale = app()->getLocale())

<div x-cloak class="mt-6" x-data="{ open: false }" x-init="setTimeout(() => open = true, 50)">
    <div class="fixed z-50 top-0 left-0 flex items-center justify-center w-full h-full px-4"
        style="background-color: rgba(0,0,0,.5);" x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="relative h-auto max-h-[90dvh] overflow-y-auto px-4 pt-6 pb-4 mx-2 text-left bg-white rounded-lg shadow-2xl md:w-3/12 lg:px-8 md:mx-0"
            @click.away="open = false" x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4">

            <button @click="open = false"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="mt-3 sm:mt-0 sm:ml-4 text-left">
                <h3 class="text-xl lg:text-3xl font-medium text-gray-800 pr-8">
                    {{ $modal->{'title_' . $locale} }}
                </h3>
            </div>

            <div class="mt-6">
                <div class="prose">
                    {!! $modal->{'content_' . $locale} !!}
                </div>
                <div class="flex space-x-2 justify-center w-full">
                    @if ($modal->{'link_' . $locale})
                        <a href="{{ $modal->{'link_' . $locale} }}"
                            class="inline-flex justify-center w-fit px-4 cursor-pointer py-2 text-white bg-primary rounded hover:bg-primary/90">
                            {{ __('View online') }}
                        </a>
                    @endif
                    <button @click="open = false"
                        class="inline-flex justify-center w-fit px-4 cursor-pointer py-2 text-white bg-red-500 rounded hover:bg-red-700">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>