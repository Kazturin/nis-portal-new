@push('styles')
    @vite('resources/css/product.css')
    <!-- <link rel="stylesheet" href="{{ asset("/css/product.css") }}"> -->
@endpush

<x-layout :metaTitle="$metaTitle">
    <div class="container mx-auto my-6 pb-10 product">

        @if ($product->{'content_' . $locale})
            <div class="mt-5 lg:mt-20 mb-20 product tiptap-content">
                {!! $product->renderRichContent('content_' . $locale) !!}
            </div>
        @endif

        @if ($product->comments->count() > 0)
            <div class="my-20">
                <h1 class="font-inter text-4xl mb-20 text-center">{{ __("Testimonials") }}</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach ($product->comments as $comment)
                        <div class="block rounded-2xl shadow-2xl border p-10">
                            <img class="w-48 h-48 rounded-full object-cover border-rich-primary border-4 mx-auto mb-10 -mt-20"
                                src="{{ $comment->getAvatar() }}" alt="">
                            <p class="font-sf text-medium text-2xl text-center">{{ $comment->{'comment_' . app()->getLocale()} }}
                            </p>
                            <p class="font-sfBold text-rich-primary text-center text-xl mt-10">
                                {{ $comment->{'author_' . app()->getLocale()} }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-layout>