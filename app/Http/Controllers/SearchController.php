<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('query');

        $locale = App::getLocale();

        $titleField = "title_$locale";
        $contentField = "content_$locale";

        $pages = Page::whereRaw("MATCH($titleField, $contentField) AGAINST(? IN BOOLEAN MODE)", [$query])->get();

        $news = News::whereRaw("MATCH($titleField, $contentField) AGAINST(? IN BOOLEAN MODE)", [$query])->get();

        $results = $pages->toBase()->merge($news);


        return view('search.index', ['results' => $results]);
    }
}
