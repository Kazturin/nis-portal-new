@props([
    'banner',
    'text',
    'subText'
])
<div class="relative h-[300px] rounded-3xl overflow-hidden">
    <!-- <div class="absolute top-0 left-0 w-full h-full bg-[#2c2c2c80]"></div> -->
    <img class="w-4/5 h-full object-cover object-center ml-auto" src="{{ $banner }}" alt="banner">
    <div class="short-gradient absolute inset-0">
        <div class="absolute top-1/2 translate-x-0 -translate-y-1/2 max-w-[495px] pl-7 lg:pl-24">
            <p class="font-inter text-3xl md:text-4xl my-4">{!! $text !!}</p>
            <p class="text-gray-200 text-base">{{ $subText }}</p>
        </div>
    </div>
</div>