@props([
    'menu',
    'current_menu',
])
    <ul class="flex flex-wrap gap-2 mb-4">
       @foreach ($menu as $item_top_menu)
         <li @class([
                    'rounded-3xl border font-sfBold px-6 py-2 hover:bg-primary hover:text-white',
                    'bg-secondary' => $current_menu != $item_top_menu->id,
                    'bg-primary text-white' => $current_menu == $item_top_menu->id,
                ])>
              <a href="{{ $item_top_menu->getUrl() }}"
              {{$item_top_menu->is_external_link ? 'target="_blank"' : ''}}>
                   {{ $item_top_menu->{'title_'.app()->getLocale()} }}
              </a>
         </li>
       @endforeach
    </ul>
