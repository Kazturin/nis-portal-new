<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\PageList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::query()
            ->where('active', true)
            ->where('title_' . app()->getLocale(), '!=', '')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('news.index', compact('news'));
    }

    public function show(?string $locale, News $news)
    {
        if (!$news->active) {
            throw new NotFoundHttpException();
        }

        $sessionKey = 'viewed_news_' . $news->id;

        if (!session()->has($sessionKey)) {
            $news->increment('views');
            session()->put($sessionKey, true);
        }

        $next = News::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '<', $news->published_at)
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        $prev = News::query()
            ->where('active', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereDate('published_at', '>', $news->published_at)
            ->orderBy('published_at', 'asc')
            ->limit(1)
            ->first();


        return view('news.show', compact('news', 'prev', 'next'));
    }
}
