<div x-data="{
    isModalOpen: false,
    images: window.galleryImages,
    currentIndex: 0,
    openModal(index) {
        this.currentIndex = index;
        this.isModalOpen = true;
    },
    nextImage() {
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
    },
    prevImage() {
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
    }
}">
    <div class="mb-4 gap-8">
                <h1 class="font-inter text-4xl my-12">{{ $title }}</h1>
                <div class="mb-10">
                    <div class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-8">
                        @foreach ($images as $index => $val)
                        <img 
                            class="rounded cursor-pointer animate-fade-in-up" 
                            src="/storage/{{ $val['image'] }}" 
                            alt="photo"
                            @click="openModal({{ $index }})">
                        @endforeach
                    </div>
                </div>
    </div>

    <!-- Модальное окно -->
    <div 
        x-cloak
        x-show="isModalOpen" 
        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50" 
        @click="isModalOpen = false"
        
       
    >
        <div class="relative w-full h-full text-center p-4" @click.stop>
            <img 
                :src="'/storage/'+images[currentIndex]['image']"
                x-data="{ shown: false }"
         x-intersect:enter="shown = true" 
         x-intersect:leave="shown = false"
         :class="{
             'opacity-0': !shown,
             'opacity-100 animate-fade-in-up': shown
         }" 
                alt="Full screen image" 
                class="max-h-full mx-4 py-10 fade-in-up"
            >
            <!-- Кнопка закрыть -->
            <button 
                class="absolute top-0 right-0 m-4 text-white bg-gray-800 px-2 py-1 rounded" 
                @click="isModalOpen = false"
            >
                {{ __('Close') }}
            </button>
            <!-- Кнопка назад -->
            <button 
                class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white bg-gray-800 px-2 py-1 rounded" 
                @click="prevImage"
            >
                ←
            </button>
            <!-- Кнопка вперёд -->
            <button 
                class="absolute right-0 top-1/2 transform -translate-y-1/2 text-white bg-gray-800 px-2 py-1 rounded" 
                @click="nextImage"
            >
                →
            </button>
            <div class="absolute bottom-0 left-0 right-0 mx-auto w-fit h-24 transition-opacity duration-300 ease-in-out">
                @foreach ($images as $index => $val)
                    <img 
                     class="inline-block rounded-md cursor-pointer w-24 h-24 object-cover  border-4 hover:opacity-80 transition duration-200" :class="{ 'border-primary': currentIndex === {{ $index }}, 'border-white': currentIndex !== {{ $index }} }" 
                    src="/storage/{{ $val['image'] }}" 
                    alt="photo"
                    @click="currentIndex={{$index}}">
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    window.galleryImages = @json($images);
</script>