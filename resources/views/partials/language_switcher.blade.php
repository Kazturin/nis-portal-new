<div class="flex items-center space-x-2">
<img class="w-5 xl:w-6" src="/img/icons/language.png" alt="">
    <form action="{{route('language')}}" method="POST">
        @csrf
        @method('post')
        <label>
            <select class="font-sf border-0 bg-transparent text-base xl:text-xl" name="locale" id="language" onchange="this.form.submit()">
                <option class="text-gray-800" value="kk" {{app()->getLocale()=='kk'?'selected':''}}>KZ</option>
                <option class="text-gray-800" value="ru" {{app()->getLocale()=='ru'?'selected':''}}>RU</option>
                <option class="text-gray-800" value="en" {{app()->getLocale()=='en'?'selected':''}}>EN</option>
            </select>
        </label>
   </form>
</div>