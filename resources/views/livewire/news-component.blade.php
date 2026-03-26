<div>
   <div class="text-center my-14">
                <a href="{{ route('news',app()->getLocale()) }}" class="font-inter text-4xl xl:text-5xl mb-16 text-center">Новости и события</a>              
            </div>
            <div> 
    </div>
    <div>
      
            <div class="flex lg:max-h-[588px] flex-col lg:flex-row"  >
                <div class="relative w-full rounded-3xl overflow-hidden lg:w-7/12">
                    <img class="w-full h-full object-cover" src="{{$news[0]->getPhoto()}}" alt="news">
                </div>
                <div class="w-full lg:w-5/12 px-4">
                  @foreach($news as $index=>$val)
                    <!-- <div class="flex flex-col lg:flex-row space-x-2 rounded-3xl overflow-hidden lg:h-1/4">
                           <img class="flex-shrink-0 w-full lg:w-4/12 rounded-xl h-full object-cover px-1 py-2" src="{{ $val->getPhoto() }}" alt="">
                        <div class="flex-1 py-2">
                          <a href="{{ route("news.show",['locale'=>app()->getLocale(),'news'=>$val->id]) }}">
                            <p class="font-sf font-semibold text-xl">{{ $val->shortTitle(80) }}</p>
                        </a>
                            <p class="font-sf opacity-60 text-sm">{{ $val->getFormattedDate() }}</p>
                        </div>
                    </div> -->
                  @endforeach
                </div>
            </div>
            <div class="flex flex-col lg:flex-row">
            <div class="relative w-full lg:w-7/12">
              <div class="lg:pl-10">
                        <a class="block my-5" href="{{ route("news.show",['locale'=>app()->getLocale(),'news'=>$news[0]]) }}">
                            <h1 class="font-sf font-semibold text-xl  opacity-90">{{ $news[0]->{'title_'.app()->getLocale()} }}</h1>
                        </a>
                        <p class="ont-sf  opacity-60 mb-5">{{ $news[0]->shortBody() }}</p>
                            <p class=" opacity-60">{{ $news[0]->getFormattedDate() }}</p>
              </div>    
            </div>
            </div>
    </div>
            
</div>
