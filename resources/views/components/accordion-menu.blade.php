@props([
    'menu',
    'pageMenu',
    'rootMenu',
    'pageParentMenu'
])

@php
    $locale = app()->getLocale();
    
    // Helper to find the active menu item in the hierarchy
    $findItem = function($items, $id) use (&$findItem) {
        foreach($items as $item) {
            if($item->id == $id) return $item;
            if($item->children && count($item->children) > 0) {
                $found = $findItem($item->children, $id);
                if($found) return $found;
            }
        }
        return null;
    };

    $activeItem = $findItem($menu, $pageMenu);
    $parentItem = $findItem($menu, $pageParentMenu);

    $drillDownItem = null;
    
    // A menu item is a drill-down candidate if it has children AND content
    $hasContent = function($item) use ($locale) {
        if (!$item) return false;
        return $item->page || $item->{'link_'.$locale} || $item->is_external_link;
    };

    // Build a map of items for upward traversal
    $flattenMenu = function($items) use (&$flattenMenu) {
        $result = [];
        foreach($items as $item) {
            $result[$item->id] = $item;
            if($item->children && count($item->children) > 0) {
                $result = $result + $flattenMenu($item->children);
            }
        }
        return $result;
    };
    $allMenuItems = $flattenMenu($menu);

    // Find the closest ancestor candidate for drill-down
    $findDrillDownRoot = function($id) use ($allMenuItems, $hasContent) {
        if (!isset($allMenuItems[$id])) return null;
        $item = $allMenuItems[$id];
        
        $pid = $item->parent_id;
        while($pid && isset($allMenuItems[$pid])) {
            $parent = $allMenuItems[$pid];
            if ($hasContent($parent) && count($parent->children) > 0) {
                return $parent;
            }
            $pid = $parent->parent_id;
        }
        return null;
    };

    $drillDownItem = $findDrillDownRoot($pageMenu);
@endphp

<div class="mb-4 text-xl font-sf">
    @if($drillDownItem)
        <div class="mb-6">
            <a href="{{ $drillDownItem->getUrl() }}" class="flex items-center text-gray-400 hover:text-primary transition-colors text-sm font-sf mb-4">
                <svg class="w-3 h-3 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>{{ __('Назад') }}</span>
            </a>
        </div>
        <ul>
            @foreach($drillDownItem->children as $child)
                @if(count($child->children) > 0)
                    <li x-data="{ child_expanded: {{ $pageParentMenu === $child->id ? 'true' : 'false' }} }" class="mb-1">
                        <div class="flex items-center justify-between hover:bg-secondary hover:rounded-3xl font-sf pr-2">
                                @if($hasContent($child))
                                     <a href="{{ $child->getUrl() }}" 
                                        @class([
                                            'px-5 py-1 block flex-grow hover:bg-secondary hover:rounded-3xl',
                                            'bg-secondary rounded-3xl' => $pageMenu === $child->id,
                                        ])>
                                         {{ $child->{'title_'.$locale} }}000
                                     </a>
                                @else
                                    <button
                                        type="button"
                                        class="flex-grow text-left px-5 py-1 font-sf"
                                        @click="child_expanded = !child_expanded"
                                    >
                                        {{ $child->{'title_'.$locale} }}
                                    </button>
                                @endif
                             <button @click="child_expanded = !child_expanded" class="p-2 transition-transform duration-200" :class="child_expanded ? 'rotate-180' : ''">
                                <svg class="w-3 h-3" viewBox="0 0 24 24">
                                    <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"/>
                                </svg>
                             </button>
                        </div>
                        <div x-cloak x-show="child_expanded" class="pl-5 overflow-hidden transition-all duration-300">
                            <ul>
                                @foreach($child->children as $l_child)
                                    <li class="mb-1">
                                        <a href="{{ $l_child->getUrl() }}"
                                            @class([
                                                'px-5 py-1 block w-fit hover:bg-secondary hover:rounded-3xl',
                                                'bg-secondary rounded-3xl' => $pageMenu === $l_child->id,
                                            ])>
                                            {{ $l_child->{'title_'.$locale} }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="mb-1">
                        <a href="{{ $child->getUrl() }}"
                           @class([
                               'px-5 py-1 block w-fit hover:bg-secondary hover:rounded-3xl',
                               'bg-secondary rounded-3xl' => $pageMenu === $child->id,
                           ])>
                           {{ $child->{'title_'.$locale} }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <ul>
        @foreach($menu as $menu_item)
            @if(count($menu_item->children)>0)
            <li x-data="{ aside_expanded: {{ ($pageParentMenu === $menu_item->id || (isset($rootMenu) && $rootMenu === $menu_item->id)) ? 'true' : 'false' }} }">
                <div class="flex items-center justify-between hover:bg-secondary hover:rounded-3xl font-sf mb-2 pr-2">
                    @if($hasContent($menu_item))
                        <a href="{{ $menu_item->getUrl() }}" 
                           @class([
                               'px-5 py-1 block flex-grow hover:bg-secondary hover:rounded-3xl',
                               'bg-secondary rounded-3xl' => $pageMenu === $menu_item->id,
                           ])>
                            {{ $menu_item->{'title_'.$locale} }}
                        </a>
                    @else
                        <button
                            type="button"
                            class="flex-grow text-left px-5 py-1 font-sf"
                            @click="aside_expanded = !aside_expanded"
                        >
                            {{ $menu_item->{'title_'.$locale} }}
                        </button>
                    @endif
                    <button
                        type="button"
                        class="p-2 transition-transform duration-200"
                        @click="aside_expanded = !aside_expanded"
                        :class="aside_expanded ? 'rotate-180' : ''"
                    >
                        <svg class="shrink-0 w-3 h-3" viewBox="0 0 24 24">
                            <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"/>
                        </svg>
                    </button>
                </div>
                <div
                    x-cloak 
                    x-show="aside_expanded"
                    id="faqs-text-{{$menu_item->id}}"
                    role="region"
                    class="grid overflow-hidden rounded-b-md transition-all duration-300 ease-in-out"
                    :class="aside_expanded ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                >
                    <div class="overflow-hidden">
                        <ul class="pl-5">
                            @foreach($menu_item->children as $child)
                            @if(count($child->children)>0)
                            <li x-data="{ child_expanded: {{ $pageParentMenu === $child->id ? 'true' : 'false' }} }">
                                <div class="flex items-center justify-between hover:bg-secondary hover:rounded-3xl font-sf mb-2 pr-2">
                                    @if($hasContent($child))
                                        <a href="{{ $child->getUrl() }}" 
                                           @class([
                                               'px-5 py-1 block flex-grow hover:bg-secondary hover:rounded-3xl',
                                               'bg-secondary rounded-3xl' => $pageMenu === $child->id,
                                           ])>
                                            {{ $child->{'title_'.$locale} }}
                                        </a>
                                    @else
                                        <button
                                            type="button"
                                            class="flex-grow text-left px-5 py-1 font-sf"
                                            @click="child_expanded = !child_expanded"
                                        >
                                            {{ $child->{'title_'.$locale} }}
                                        </button>
                                        <button
                                        type="button"
                                        class="p-2 transition-transform duration-200"
                                        @click="child_expanded = !child_expanded"
                                        :class="child_expanded ? 'rotate-180' : ''"
                                    >
                                        <svg class="shrink-0 w-3 h-3" viewBox="0 0 24 24">
                                            <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"/>
                                        </svg>
                                    </button>
                                    @endif
                                    
                                </div>
                                <div
                                    x-cloak 
                                    x-show="child_expanded"
                                    class="grid overflow-hidden rounded-b-md transition-all duration-300 ease-in-out"
                                    :class="child_expanded ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'"
                                >
                                    <div class="overflow-hidden">
                                        <ul class="pl-5">
                                            @foreach($child->children as $l_child)
                                                <li class="mb-1">
                                                  <a href="{{ $l_child->getUrl() }}"
                                                  {{$l_child->is_external_link ? 'target="_blank"' : ''}}
                                                  @class([
                                                      'px-5 py-1 block w-fit hover:bg-secondary hover:rounded-3xl',
                                                      'bg-secondary rounded-3xl' =>  isset($pageMenu) && $pageMenu===$l_child->id,
                                                  ])>
                                                     {{ $l_child->{'title_'.$locale} }}
                                                  </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            @else
                                <li class="mb-1">
                                  <a href="{{ $child->getUrl() }}"
                                  {{$child->is_external_link ? 'target="_blank"' : ''}}
                                  @class([
                                      'px-5 py-1 block w-fit hover:bg-secondary hover:rounded-3xl',
                                      'bg-secondary rounded-3xl' =>  isset($pageMenu) && $pageMenu===$child->id,
                                  ])>
                                     {{ $child->{'title_'.$locale} }}
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
                <a href="{{ $menu_item->getUrl() }}"
                @class([
                    'px-5 py-1 block w-fit hover:bg-secondary hover:rounded-3xl',
                    'bg-secondary rounded-3xl' => isset($pageMenu) && $pageMenu==$menu_item->id,
                ])
                {{$menu_item->is_external_link ? 'target="_blank"' : ''}}>
                   {{ $menu_item->{'title_'.$locale} }}
                </a>
                </li>
            @endif
        @endforeach
        </ul>
    @endif
</div>