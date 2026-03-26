<div x-data="{ menuVisible: false }" class="relative inline-block text-left">
    <!-- Кнопка выбора -->
    <button @click="menuVisible = !menuVisible" class="flex items-center w-full justify-center px-4 font-medium">
       <img class="w-5 xl:w-6 mr-3" src="/img/icons/language.png" alt=""> 
       <span class="text-sf text-xl uppercase">{{ $languagesLabel[$currentLanguage]  }}</span> 
       <svg class="-mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>
    </button>

    <!-- Выпадающее меню -->
    <div x-cloak x-show="menuVisible" @click.away="menuVisible = false" class="absolute left-1/2 transform -translate-x-1/2 mt-2 w-24 z-20 origin-top rounded-3xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 p-2">
        <div class="py-1 text-sf text-xl">
            <button wire:click="changeLanguage('kk')" 
                @click="menuVisible = false" 
                class="block w-full rounded-3xl px-4 py-2 hover:text-white hover:bg-primary">KZ</button>
            <button wire:click="changeLanguage('ru')" 
                @click="menuVisible = false" 
                class="block w-full rounded-3xl px-4 py-2 hover:text-white hover:bg-primary ">RU</button>
            <button wire:click="changeLanguage('en')" 
                @click="menuVisible = false" 
                class="block w-full rounded-3xl px-4 py-2 hover:text-white  hover:bg-primary">EN</button>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('language-changed', (event) => {

        const language = event[0].language;
        const currentUrl = new URL(window.location.href);

        const segments = currentUrl.pathname.split('/');
        if (['kk', 'ru', 'en'].includes(segments[1])) {
            segments[1] = language;
        } else {
            segments.splice(1, 0, language); // Добавляем сегмент языка
        }

        const newPath = segments.join('/');
        window.location.href = currentUrl.origin + newPath;
    });
</script>
@endscript