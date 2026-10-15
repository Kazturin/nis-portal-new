<x-layout>
    <div>
        @include('partials.home.hero', ['mission' => $mission])

        @if ($cards)
        <div class="container mx-auto mt-10 mb-6">
            {!! $cards->renderRichContent('content_' . app()->getLocale()) !!}
        </div>
        @endif

        <div class="container mx-auto mb-6">
            @include('partials.home.partners', ['partners' => $partners])
            @include('partials.home.news', ['mainNews' => $mainNews, 'sideNews' => $sideNews])
            @include('partials.home.opportunities', ['opportunities_block' => $opportunities_block, 'advantages' => $advantages])
        </div>
        @include('partials.home.ads', ['ads' => $ads])
        <div class="container mx-auto my-6">

            @include('partials.home.resources', ['resources_block' => $resources_block, 'resources' => $resources])
        </div>

        @include('partials.home.statistics', ['statistics' => $statistics])
        @include('partials.home.faq', ['faq' => $faq])

        @if ($modal)
            @include('partials.home.modal', ['modal' => $modal])
        @endif

        @push('scripts')
            <script src="{{ asset('/js/swiper-bundle.min.js') }}"></script>
            <script src="{{ asset('/js/home-sliders.js') }}"></script>
        @endpush
    </div>
</x-layout>