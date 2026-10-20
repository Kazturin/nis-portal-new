@php
    $locale = in_array(request()->segment(1), ['ru', 'kk', 'en'], true)
        ? request()->segment(1)
        : app()->getLocale();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('site.page_not_found_title', [], $locale) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen">
<!-- ====== Error 404 Section Start -->
<section class="relative z-10 h-full">
   <div class="container mx-auto ">
      <div class="-mx-4 flex h-[calc(100vh-80px)] items-center justify-center">
         <div class="w-full px-4">
            <div class="mx-auto text-center">
               <img class="mx-auto w-32 mb-9" src="/img/not-found-icon.png" alt="">
               <h1 class="font-inter text-[40px] mb-4">{{ __('site.page_not_found_heading', [], $locale) }}</h1>
               <p class="font-interReg text-2xl mb-7">{{ __('site.page_not_found_description', [], $locale) }}</p>
               <div class="flex flex-wrap justify-center gap-4">
                  <a
                     href="{{ url('/' . $locale) }}"
                     class="inline-block rounded-3xl font-sf text-white bg-primary hover:bg-rich-primary text-center text-xl font-semibold px-6 py-3"
                     >
                     {{ __('site.go_to_home', [], $locale) }}
                  </a>
                  <a
                     href="{{ url()->previous() }}"
                     class="inline-block rounded-3xl font-sf text-white bg-primary hover:bg-rich-primary text-center text-xl font-semibold px-6 py-3"
                     >
                     {{ __('Go back', [], $locale) }}
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div
      class="absolute top-0 left-0 -z-10 flex h-full w-full items-center justify-between space-x-5 md:space-x-8 lg:space-x-14"
      >
      <div
         class="h-full w-1/3 bg-gradient-to-t from-[#FFFFFF14] to-[#C4C4C400]"
         ></div>
      <div class="flex h-full w-1/3">
         <div
            class="h-full w-1/2 bg-gradient-to-b from-[#FFFFFF14] to-[#C4C4C400]"
            ></div>
         <div
            class="h-full w-1/2 bg-gradient-to-t from-[#FFFFFF14] to-[#C4C4C400]"
            ></div>
      </div>
      <div
         class="h-full w-1/3 bg-gradient-to-b from-[#FFFFFF14] to-[#C4C4C400]"
         ></div>
   </div>
</section>
<!-- ====== Error 404 Section End -->

</body>

</html>

