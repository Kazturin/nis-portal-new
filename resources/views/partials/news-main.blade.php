<div class="font-sf">
    <a class="block my-5" href="{{ route('news.show', ['locale' => app()->getLocale(), 'news' => $news]) }}">
        <h1 class="font-sf font-semibold text-xl  ">{{ $news->{'title_' . app()->getLocale()} }}</h1>
    </a>
    <p class="font-sf  opacity-60 mb-5">{{ $news->shortBody() }}</p>
    <p class="font-sf opacity-60 mb-3">{{ $news->getFormattedDate() }}</p>
</div>