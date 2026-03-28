<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $metaTitle?: __("site.app_title")}}</title>
    <meta name="description" content="{{ $metaDescription?:__("site.app_description") }}">
    <meta property="og:title" content="{{ $metaTitle?: ''}}">
    <meta property="og:description" content="{{ $metaDescription?:__("site.app_description") }}">
    <meta property="og:image" content="{{ $metaImage ?: '/img/not_photo.png' }}">
    <link rel="stylesheet" href="{{ asset("css/bvi/bvi.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/css/swiper-bundle.min.css") }}">
   


    <!-- Yandex.Metrika counter -->
    <!-- <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(51153680, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/51153680" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript> -->
    <!-- /Yandex.Metrika counter -->

    @livewireStyles
    @vite('resources/css/app.css')
    @stack('styles')

</head>

<body>

    <header x-data="{ openMenu: null, isBurgerMenuOpen: false }" class="relative">
        <div x-cloak x-show="openMenu!==null" class="fixed z-30 w-screen h-screen inset-0 bg-gray-900 opacity-30"></div>
        <nav class="sticky top-0 bg-white z-50">
            <div class="py-2">
                <div class="container p-4 mx-auto" @click.outside="openMenu = null">
                    <div class="flex items-center justify-between font-sf space-x-2 md:space-x-6 border-b border-gray-200 pb-2">
                        
                        <div>
                            @if($top_button)
                            {!! $top_button->{'content_'.app()->getLocale()} !!}
                            @endif
                        </div>
                       
                        <div class="flex items-center justify-end font-sf space-x-6 text-base xl:text-xl">
                            <div class="hidden lg:block">
                                <x-search-input />
                            </div>
                            <div class="hidden lg:block">

                                <div class="flex items-center text-light">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd">
                                        <path d="M8.26 1.289l-1.564.772c-5.793 3.02 2.798 20.944 9.31 20.944.46 0 .904-.094 1.317-.284l1.542-.755-2.898-5.594-1.54.754c-.181.087-.384.134-.597.134-2.561 0-6.841-8.204-4.241-9.596l1.546-.763-2.875-5.612zm7.746 22.711c-5.68 0-12.221-11.114-12.221-17.832 0-2.419.833-4.146 2.457-4.992l2.382-1.176 3.857 7.347-2.437 1.201c-1.439.772 2.409 8.424 3.956 7.68l2.399-1.179 3.816 7.36s-2.36 1.162-2.476 1.215c-.547.251-1.129.376-1.733.376" />
                                    </svg>
                                    {!! $call_center->{'content_'.app()->getLocale()} !!}
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="#" class="bvi-open">
                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0001 5.25C9.22586 5.25 6.79699 6.91121 5.12801 8.44832C4.28012 9.22922 3.59626 10.0078 3.12442 10.5906C2.88804 10.8825 2.70368 11.1268 2.57736 11.2997C2.51417 11.3862 2.46542 11.4549 2.43187 11.5029C2.41509 11.5269 2.4021 11.5457 2.393 11.559L2.38227 11.5747L2.37911 11.5794L2.10547 12.0132L2.37809 12.4191L2.37911 12.4206L2.38227 12.4253L2.393 12.441C2.4021 12.4543 2.41509 12.4731 2.43187 12.4971C2.46542 12.5451 2.51417 12.6138 2.57736 12.7003C2.70368 12.8732 2.88804 13.1175 3.12442 13.4094C3.59626 13.9922 4.28012 14.7708 5.12801 15.5517C6.79699 17.0888 9.22586 18.75 12.0001 18.75C14.7743 18.75 17.2031 17.0888 18.8721 15.5517C19.72 14.7708 20.4039 13.9922 20.8757 13.4094C21.1121 13.1175 21.2964 12.8732 21.4228 12.7003C21.4859 12.6138 21.5347 12.5451 21.5682 12.4971C21.585 12.4731 21.598 12.4543 21.6071 12.441L21.6178 12.4253L21.621 12.4206L21.6224 12.4186L21.9035 12L21.622 11.5809L21.621 11.5794L21.6178 11.5747L21.6071 11.559C21.598 11.5457 21.585 11.5269 21.5682 11.5029C21.5347 11.4549 21.4859 11.3862 21.4228 11.2997C21.2964 11.1268 21.1121 10.8825 20.8757 10.5906C20.4039 10.0078 19.72 9.22922 18.8721 8.44832C17.2031 6.91121 14.7743 5.25 12.0001 5.25ZM4.29022 12.4656C4.14684 12.2885 4.02478 12.1311 3.92575 12C4.02478 11.8689 4.14684 11.7115 4.29022 11.5344C4.72924 10.9922 5.36339 10.2708 6.14419 9.55168C7.73256 8.08879 9.80369 6.75 12.0001 6.75C14.1964 6.75 16.2676 8.08879 17.8559 9.55168C18.6367 10.2708 19.2709 10.9922 19.7099 11.5344C19.8533 11.7115 19.9753 11.8689 20.0744 12C19.9753 12.1311 19.8533 12.2885 19.7099 12.4656C19.2709 13.0078 18.6367 13.7292 17.8559 14.4483C16.2676 15.9112 14.1964 17.25 12.0001 17.25C9.80369 17.25 7.73256 15.9112 6.14419 14.4483C5.36339 13.7292 4.72924 13.0078 4.29022 12.4656ZM14.25 12C14.25 13.2426 13.2427 14.25 12 14.25C10.7574 14.25 9.75005 13.2426 9.75005 12C9.75005 10.7574 10.7574 9.75 12 9.75C13.2427 9.75 14.25 10.7574 14.25 12ZM15.75 12C15.75 14.0711 14.0711 15.75 12 15.75C9.92898 15.75 8.25005 14.0711 8.25005 12C8.25005 9.92893 9.92898 8.25 12 8.25C14.0711 8.25 15.75 9.92893 15.75 12Z" fill="#080341" />
                                </svg>
                                </a>
                                

                                <a href="#" class="hidden lg:block bvi-open text-[#808080] leading-tight">
                                    {{ __("For the visually impaired") }}
                                </a>
                            </div>

                            <livewire:language-selector />
                        </div>

                        <!-- louout -->
                    </div>
                    <div class="flex items-center py-2" aria-label="Global">
                        <div class="flex lg:hidden">
                            <button type="button" @click="isBurgerMenuOpen=!isBurgerMenuOpen"
                                class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                                <span class="sr-only">Open main menu</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                        </div>
                        <div class="hidden lg:flex items-start space-x-4 text-base xl:text-xl font-sf">
                            <a href="/"><img src="/img/ornament.png" alt="ornament" class="w-10"></a>
                            @foreach($menu as $item)
                            @if(count($item->children)>0 && !($item->page || $item->{'link_'.app()->getLocale()} || $item->is_external_link))
                            <div class="relative">
                                <button
                                    @click="openMenu === {{ $item->id }} ? openMenu = null : openMenu = {{ $item->id }}"
                                    type="button"
                                    class="flex items-center gap-x-1 py-2 px-4"
                                    :class="{ 'bg-secondary rounded-3xl' : openMenu ==={{ $item->id }} }"
                                    aria-expanded="false">
                                    {{ $item->{'title_'.app()->getLocale()} }}
                                    <svg class="h-5 w-5 flex-none" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-cloak x-show="openMenu === {{ $item->id }}"
                                    class="absolute -left-8 top-full z-50 mt-3 w-screen max-w-96 overflow-hidden text-gray-700 rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5 px-5 py-4"
                                    x-transition:enter="transition ease-out duration-200 transform"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150 transform"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-2"
                                    aria-label="submenu">
                                    <div>
                                        <ul class="list-none">
                                            @foreach($item->children as $child_item)
                                            @if(count($child_item->children)>0 && !($child_item->page || $child_item->{'link_'.app()->getLocale()} || $child_item->is_external_link))
                                            <li class="mb-2" x-data="{ expanded: false }">
                                                <button id="faqs-title-{{$child_item->id}}" type="button"
                                                    class="flex items-center justify-between w-full hover:bg-primary hover:text-white hover:rounded-3xl px-4 py-2 text-left"
                                                    @click="expanded = !expanded" :aria-expanded="expanded"
                                                    aria-controls="faqs-text-{{$child_item->id}}">
                                                    <span>{{ $child_item->{'title_'.app()->getLocale()} }}</span>
                                                    <svg class="shrink-0 ml-8 w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z" />
                                                    </svg>
                                                </button>
                                                <div x-show="expanded" id="faqs-text-{{$child_item->id}}" role="region"
                                                    aria-labelledby="faqs-title-01"
                                                    class="grid overflow-hidden rounded-b-md transition-all duration-300 ease-in-out px-4 py-2"
                                                    :class="expanded ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                                                    x-transition:enter="transition ease-out duration-200 transform"
                                                    x-transition:enter-start="opacity-0 translate-y-2"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    x-transition:leave="transition ease-in duration-150 transform"
                                                    x-transition:leave-start="opacity-100 translate-y-0"
                                                    x-transition:leave-end="opacity-0 translate-y-2">
                                                    <div class="overflow-hidden">
                                                        <ul class="list-none">
                                                            @foreach($child_item->children as $child)
                                                            @if(count($child->children)>0 && !($child->page || $child->{'link_'.app()->getLocale()} || $child->is_external_link))
                                                            <li class="mb-2" x-data="{ expanded: false }">
                                                                <button id="faqs-title-{{$child_item->id}}" type="button"
                                                                    class="flex items-center justify-between w-full hover:bg-primary hover:text-white hover:rounded-3xl text-left mt-2 px-4 py-2"
                                                                    @click="expanded = !expanded" :aria-expanded="expanded"
                                                                    aria-controls="faqs-text-{{$child->id}}">
                                                                    <span>{{ $child->{'title_'.app()->getLocale()} }}</span>
                                                                    <svg class="shrink-0 ml-8 w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                                                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="expanded" id="faqs-text-{{$child->id}}" role="region"
                                                                    aria-labelledby="faqs-title-01"
                                                                    class="grid overflow-hidden rounded-b-md transition-all duration-300 ease-in-out px-4 py-2"
                                                                    :class="expanded ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                                                                    x-transition:enter="transition ease-out duration-200 transform"
                                                                    x-transition:enter-start="opacity-0 translate-y-2"
                                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                                    x-transition:leave="transition ease-in duration-150 transform"
                                                                    x-transition:leave-start="opacity-100 translate-y-0"
                                                                    x-transition:leave-end="opacity-0 translate-y-2">
                                                                    <div class="overflow-hidden">
                                                                        <ul class="list-none">
                                                                            @foreach($child->children as $last_child)
                                                                            <li>
                                                                                <a
                                                                                    href="{{ $last_child->getUrl() }}"
                                                                                    {{$last_child->open_in_new_tab ? 'target="_blank"' : ''}}
                                                                                    class="block hover:bg-primary hover:text-white hover:rounded-3xl px-4 py-2">
                                                                                    {{ $last_child->{'title_'.app()->getLocale()} }}
                                                                                </a>
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            @else
                                                            <li>
                                                                <a
                                                                    href="{{ $child->getUrl() }}"
                                                                    {{$child->open_in_new_tab ? 'target="_blank"' : ''}}
                                                                    class="block hover:bg-primary hover:text-white hover:rounded-3xl px-4 py-2">
                                                                    {{ $child->{'title_'.app()->getLocale()} }}
                                                                </a>
                                                            </li>
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            @else
                                            <li class="mb-2">
                                                <a
                                                    href="{{ $child_item->getUrl() }}"
                                                    {{$child_item->open_in_new_tab ? 'target="_blank"' : ''}}
                                                    class="block hover:bg-primary hover:text-white hover:rounded-3xl px-4 py-2">
                                                    {{ $child_item->{'title_'.app()->getLocale()} }}
                                                </a>
                                            </li>

                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            @else
                            <div class="py-2 px-4 text-center">
                                <a href="{{ $item->getUrl() }}"
                                    {{$item->open_in_new_tab ? 'target="_blank"' : ''}}>{{ $item->{'title_'.app()->getLocale()} }}</a>
                            </div>

                            @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div x-data="{ openMobileMenu: null }" x-cloak x-show="isBurgerMenuOpen" class="lg:hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 z-10"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <img class="h-8 w-auto" src="/img/logo.png" alt="logo">
                    </a>
                    <button type="button" @click="isBurgerMenuOpen=false" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-5 flow-root">
                    <div class="mb-4">
                        <x-search-input />
                    </div>

                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <div x-data="{ openChildMenu: null }" class="-mx-3">
                                <div class="mt-2 space-y-2">
                                    <button type="button" class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50" aria-controls="disclosure-1" aria-expanded="false">
                                        <a href="/">
                                            {{ __("Main") }}
                                        </a>
                                    </button>

                                </div>
                                @foreach($menu as $item)
                                @if(count($item->children)>0 && !($item->page || $item->{'link_'.app()->getLocale()} || $item->is_external_link))
                                <button @click="openMobileMenu === {{ $item->id }} ? openMobileMenu = null : openMobileMenu = {{ $item->id }}" type="button" class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50" aria-controls="disclosure-1" aria-expanded="false">
                                    {{ $item->{'title_'.app()->getLocale()} }}
                                    <svg class="h-5 w-5 flex-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="openMobileMenu === {{ $item->id }}"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2" x-show="openMobileMenu === {{ $item->id }}" class="my-2 space-y-2 ml-3 border-primary border-l" id="disclosure-1">
                                    @foreach($item->children as $child_item)
                                    @if(count($child_item->children)>0 && !($child_item->page || $child_item->{'link_'.app()->getLocale()} || $child_item->is_external_link))
                                    <button @click="openChildMenu === {{ $child_item->id }} ? openChildMenu = null : openChildMenu = {{ $child_item->id }}" type="button" class="flex w-full items-center justify-between rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50" aria-controls="disclosure-1" aria-expanded="false">
                                        {{ $child_item->{'title_'.app()->getLocale()} }}
                                        <svg class="h-5 w-5 flex-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-data="{ openLlChildMenu: null }" x-show="openChildMenu === {{ $child_item->id }}" class="mt-2 space-y-2 ml-6 pl-6 border-primary border-l" id="disclosure-1">
                                        @foreach($child_item->children as $child)
                                        @if(count($child->children)>0 && !($child->page || $child->{'link_'.app()->getLocale()} || $child->is_external_link))
                                        <button @click="openLlChildMenu === {{ $child->id }} ? openLlChildMenu = null : openLlChildMenu = {{ $child->id }}" type="button" class="flex w-full items-center justify-between rounded-lg py-2 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50" aria-controls="disclosure-1" aria-expanded="false">
                                            {{ $child->{'title_'.app()->getLocale()} }}
                                            <svg class="h-5 w-5 flex-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div x-show="openLlChildMenu === {{ $child->id }}"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                                            x-transition:enter-end="opacity-100 transform translate-y-0"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 transform translate-y-0"
                                            x-transition:leave-end="opacity-0 transform -translate-y-2" class="my-2 space-y-2 pl-6 border-primary border-l" id="disclosure-1">
                                            @foreach($child->children as $ll_child)
                                            <a href="{{ $ll_child->getUrl() }}" {{$ll_child->open_in_new_tab ? 'target="_blank"' : ''}}
                                                class="block rounded-lg pr-3 text-sm font-semibold leading-7 text-gray-900">
                                                {{ $ll_child->{'title_'.app()->getLocale()} }}
                                            </a>
                                            @endforeach
                                        </div>
                                        @else
                                        <a href="{{ $child->getUrl() }}" {{$child->open_in_new_tab ? 'target="_blank"' : ''}}
                                            class="block rounded-lg pr-3 text-sm font-semibold leading-7 text-gray-900">
                                            {{ $child->{'title_'.app()->getLocale()} }}
                                        </a>

                                        @endif


                                        @endforeach
                                    </div>
                                    @else
                                    <a href="{{ $child_item->getUrl() }}" {{$child_item->open_in_new_tab ? 'target="_blank"' : ''}}
                                        class="block rounded-lg pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900">
                                        {{ $child_item->{'title_'.app()->getLocale()} }}
                                    </a>

                                    @endif
                                    @endforeach
                                </div>
                                @else
                                <a class="block py-2 pl-3 pr-3.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50"
                                    href="{{ $item->getUrl() }}" {{$item->open_in_new_tab ? 'target="_blank"' : ''}}>{{ $item->{'title_'.app()->getLocale()} }}</a>
                                @endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>
    <div x-data="{ isVisible: false }" x-init="window.addEventListener('scroll', () => { isVisible = window.scrollY > 100; })" class="fixed bottom-10 right-6 md:right-20 z-50" x-show="isVisible" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-2">
        <button title="Scroll to top" aria-label="Scroll to top" @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="rounded-full bg-primary p-2 text-sm font-semibold text-white shadow-xl hover:bg-white hover:text-primary border-4 border-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600 w-full">
            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <g id="top-2" data-name="top">
                    <path d="m29 19.52-12.29-12.34a1 1 0 0 0 -1.42 0l-12.29 12.34a3.27 3.27 0 0 0 0 4.63 3.35 3.35 0 0 0 4.63 0l8.37-8.41 8.41 8.41a3.27 3.27 0 1 0 4.59-4.63z" />
                </g>
            </svg>
        </button>
    </div>
    <footer class="w-full bg-gray-100 pt-12 pb-6">
        <div class="w-full container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-12">
                @foreach($footerMenu as $item)
                @if(count($item->children)>0)
                <div class="mb-4">
                    <h1 class="font-sf font-semibold text-2xl my-4">{{ $item->{'title_'.app()->getLocale()} }}</h1>
                    <ul class="list-none">
                        @foreach($item->children as $child_item)
                        <li class="mb-2">
                            @if(count($child_item->children)>0)
                            <a href="{{  route('page', ['locale' => app()->getLocale(), 'page' => $child_item->children[0]->page]) }}" class="text-lg text-gray-600 hover:text-primary">{{ $child_item->{'title_'.app()->getLocale()} }}</a>
                            @else
                            <a href="{{ $child_item->getUrl() }}" {{$child_item->open_in_new_tab ? 'target="_blank"' : ''}} class="text-lg text-gray-600 hover:text-primary">{{ $child_item->{'title_'.app()->getLocale()} }}</a>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @else
                <div>
                    <a href="{{ $item->getUrl() }}">
                        <h1 class="font-sf font-semibold text-2xl my-4">{{ $item->{'title_'.app()->getLocale()} }}</h1>
                    </a>
                </div>
                @endif
                @endforeach
                <div>
                    <h1 class="font-sf font-semibold text-2xl my-4">{{ __("Address") }}</h1>
                    <p class="text-gray-600 text-lg">{{__("Republic of Kazakhstan 010000, Astana 21/1 Hussein ben Talal Street")}}</p>
                    <a class="block text-gray-600  text-lg my-4 underline" href="/{{ app()->getLocale() }}/page/nazarbaev-ziiatkerlik-mektepteri-derbes-bilim-beru-uiymy">{{ __("Contacts") }} </a>
                </div>
                <div>
                    <h1 class="font-sf font-semibold text-2xl my-4">{{ __("Helpline") }}</h1>
                    @if ($helpline)
                    <div class="text-lg text-cyan-600">
                        {!! $helpline->content_kk !!}
                    </div>
                    @endif

                </div>
                <div>
                    <h1 class="font-sf font-semibold text-2xl my-4">{{ __("Social media") }}</h1>
                    <div class="flex space-x-3">
                        <a href="https://www.instagram.com/nis_qazaqstan/" target="_blank"><img class="w-5 h-5" src="/img/icons/Instagram.png" alt="instagram"></a>
                        <a href="https://www.youtube.com/@nis_qazaqstan" target="_blank"><img class="w-5 h-5" src="/img/icons/youtube.png" alt="youtube"></a>
                        <a href="https://www.facebook.com/OfficialNIS" target="_blank"><img class="w-5 h-5" src="/img/icons/facebook.png" alt="facebook"></a>
                        <a href="https://t.me/official_nis" target="_blank"><img class="w-5 h-5" src="/img/icons/telegram.png" alt="telegram"></a>
                    </div>
                </div>

            </div>


            <div class="flex flex-col md:flex-row items-center space-x-4 pb-2 mb-4 border-b border-gray-200">
                <img class="hidden md:block w-32" src="/img/tovarny_znak.png" alt="logo">
                <div>
                    {!! $trademark->{'content_'.app()->getLocale()} !!}
                </div>
            </div>
            <div class="flex flex-col lg:flex-row justify-between">
                <p>©2025 {{__("Autonomous educational Organization «Nazarbayev Intellectual Schools»")}}</p>
                <div class="flex space-x-4 text-light">
                    <span>info@nis.edu.kz</span>
                    <span>www.nis.edu.kz</span>
                </div>
            </div>

        </div>

    </footer>

    @livewireScripts
    <script src="/js/bvi/bvi.min.js"></script>
    <script>
        new isvek.Bvi({
            target: '.bvi-open',
            fontSize: 14,
        })
    </script>
    <script>
        document.addEventListener('alpine:init', () => {
            console.log('test');
            //         


            Alpine.store('accordion', {
                tab: 0
            });

            Alpine.data('accordion', (idx) => ({
                init() {
                    this.idx = idx;
                },
                idx: -1,
                handleClick() {
                    this.$store.accordion.tab = this.$store.accordion.tab === this.idx ? 0 : this.idx;
                },
                handleRotate() {
                    return this.$store.accordion.tab === this.idx ? 'rotate-180' : '';
                },
                handleToggle() {
                    return this.$store.accordion.tab === this.idx ? `max-height: ${this.$refs.tab.scrollHeight}px` : '';
                }
            }));
        })

        //     document.addEventListener('DOMContentLoaded', function () {
        //     var form = document.getElementById('searchForm');
        //     var input = document.getElementById('query');

        //     input.addEventListener('keypress', function (e) {
        //         var key = e.which || e.keyCode;
        //         if (key === 13) { // Код клавиши Enter
        //             form.submit();
        //         }
        //     });
        // });
    </script>

    @stack('scripts')

</body>

</html>