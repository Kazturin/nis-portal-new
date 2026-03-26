<div class="relative h-[350px] rounded-3xl overflow-hidden my-10">
    <!-- <div class="absolute top-0 left-0 w-full h-full bg-[#2c2c2c80]"></div> -->
    <img class="w-4/5 h-full object-cover object-center ml-auto" src="/storage/{{ $banner }}" alt="banner">
    <div class="short-gradient absolute inset-0">
        <div class="absolute top-1/2 translate-x-0 -translate-y-1/2 max-w-[495px] pl-7 lg:pl-24">
            <p class="font-inter text-2xl md:text-4xl my-8">{{ $title }}</p>
            <div class="font-sf text-2xl font-medium">{!! $text !!}</div>
        </div>
    </div>
</div>