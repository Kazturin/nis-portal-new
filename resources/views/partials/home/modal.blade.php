@php($locale = app()->getLocale())

<div x-cloak class="mt-6" x-data="{ open: true }">
    <div class="fixed z-50 top-0 left-0 flex items-center justify-center w-full h-full"
        style="background-color: rgba(0,0,0,.5);" x-show="open" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="h-auto px-4 pt-6 pb-4 mx-2 text-left bg-white rounded shadow-xl md:w-4/12 lg:px-8 md:mx-0"
            @click.away="open = false">
            <div class="mt-3 sm:mt-0 sm:ml-4 text-left">
                <h3 class="text-xl lg:text-3xl font-medium text-gray-800">
                    {{ $modal->{'title_' . $locale} }}
                </h3>
            </div>

            <div class="mt-6">
                <div class="prose">
                    {!! $modal->{'content_' . $locale} !!}
                </div>
                <div class="flex space-x-2 justify-center w-full">

                    <button @click="open = false"
                        class="inline-flex justify-center w-fit px-4 cursor-pointer py-2 text-white bg-red-500 rounded hover:bg-red-700">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>