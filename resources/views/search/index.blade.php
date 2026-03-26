<x-layout>
  <div class="container mx-auto my-8 px-4">
    <div class="my-4 relative">
      <form id="searchForm" action="{{ route('search', ['locale' => app()->getLocale()]) }}">
        <input type="text" name="query" id="query" value="{{request()->input('query')}}"
          class="w-full border-gray-400 border p-2 rounded-md" placeholder="сайт бойынша іздеу">
        <button type="submit" class="absolute top-0 bottom-0 right-2">
          <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
            viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
            width="512px" height="512px">
            <path
              d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
          </svg>
        </button>
      </form>
    </div>

    @if ($results->isEmpty())
      <p>{{ __("No results found") }}.</p>
    @else
      <ul>
        @foreach ($results as $page)
          <li class="py-2 border-b border-gray-200">
            <h2 class="font-semibold my-2">{{ $page->{'title_' . app()->getLocale()} }}</h2>
            @php

              $content = strip_tags($page->{'content_' . app()->getLocale()});
              $query = request()->input('query');
              $pos = mb_stripos($content, $query, 0, 'UTF-8');
              $start = max(0, $pos - 50); // Начинаем 50 символов до найденного слова
              $end = min(mb_strlen($content, 'UTF-8'), $pos + 50); // Заканчиваем 50 символов после найденного слова
              $excerpt = mb_substr($content, $start, $end - $start, 'UTF-8');
              $highlightedExcerpt = preg_replace('/(' . preg_quote($query, '/') . ')/iu', '<strong class="text-primary">$1</strong>', $excerpt);

            @endphp
            <p class="mb-2">{!! $highlightedExcerpt !!}</p>
            <a class="flex space-x-4 items-center text-base text-primary italic" href="{{ $page->url }}">
              <span>{{ __('Go to page') }}</span>
              <svg width="27" height="13" viewBox="0 0 27 13" fill="currentColor">
                <path
                  d="M21.1523 12.5157L26.4594 7.2086C26.7851 6.88293 26.7851 6.35492 26.4594 6.02925L21.1523 0.72216C20.8267 0.39649 20.2987 0.39649 19.973 0.722161C19.6473 1.04783 19.6473 1.57584 19.973 1.90151L23.8565 5.785L0.032226 5.785L0.0322261 7.45286L23.8565 7.45286L19.973 11.3363C19.6473 11.662 19.6473 12.19 19.973 12.5157C20.2987 12.8414 20.8267 12.8414 21.1523 12.5157Z">
                </path>
              </svg>
            </a>
          </li>
        @endforeach
      </ul>
      <div>

      </div>
    @endif

  </div>

</x-layout>