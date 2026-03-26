<div>
<div class="my-4">
                <h1 class="text-3xl font-semibold uppercase">{{ __("Figures and Facts") }}</h1>
                <div class="bg-primary h-[3px] w-[50px] my-4"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="py-4">
                    <h1 class="text-[160px] py-4">{{ $current->value }}</h1>
                    <div class="text-xl tracking-widest">
                        {!! $current->{'description_'.app()->getLocale()} !!}
                    </div>
                </div>
                <div>
                    <div class="grid grid-cols-3 auto-rows-[200px] gap-2">
                    @foreach ($statistics as $key=>$item)
                    @if ($current->value===$item->value)
                    <div class="flex items-center justify-center">
                        <img class="w-28" src="/img/ornament.png" alt="ornament">
                    </div>
                    
                    @else
                     <div wire:click="selectItem({{ $key }})" class="flex justify-center items-center cursor-pointer bg-[#00000033] text-2xl">
                        {{ $item->value}}
                    </div>
                    @endif
                    @endforeach
                   
                </div>
                </div>
                
                </div>
</div>

