<div x-data="{ tab: '{{ $tabs[0]['id'] ?? '' }}' }" class="tabs flex flex-col items-center">
    <!-- Навигация -->
    <nav
        class="flex overflow-x-auto items-center p-1 space-x-1 rtl:space-x-reverse text-sm text-gray-600 bg-gray-500/5 rounded-xl dark:bg-gray-500/20">

        @foreach($tabs as $t)
            <button @click="tab = '{{ $t['id'] }}'"
                :class="tab === '{{ $t['id'] }}' 
                            ? 'text-yellow-600 shadow bg-white dark:text-white dark:bg-yellow-600' 
                            : 'hover:text-gray-800 focus:text-yellow-600 dark:text-gray-400 dark:hover:text-gray-300 dark:focus:text-gray-400'"
                class="flex whitespace-nowrap items-center h-8 px-2 md:px-5 font-medium rounded-lg outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-inset"
                role="tab" type="button" :aria-selected="tab === '{{ $t['id'] }}'">
                {{ $t['title_' . app()->getLocale()] }}
            </button>
        @endforeach
    </nav>

    <!-- Контент -->
    <div class="mt-4 w-full">
        @foreach($tabs as $t)
            <div x-show="tab === '{{ $t['id'] }}'" class="px-4 rounded-lg">
                <p class="text-gray-600">{!! $t['content_' . app()->getLocale()] !!}</p>
            </div>
        @endforeach
    </div>
</div>