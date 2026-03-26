<?php
namespace App\Services\Page;

use Illuminate\Support\Facades\Cache;
use App\Models\News;
use App\Models\Advantage;
use App\Models\Ad;
use App\Models\PhotoGallery;
use App\Models\OtherResource;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;

class HomePageDataFetcher
{
    protected $locale;
    protected $cacheDuration;

    public function __construct()
    {
        $this->locale = app()->getLocale();
        $this->cacheDuration = now()->addDays(1);
    }

    public function getNews()
    {
        $cacheKey = "news_homepage_{$this->locale}";
        $rawData = Cache::remember($cacheKey, $this->cacheDuration, function () {
            $news = News::query()
                ->select(['id', 'active', 'published_at', "title_{$this->locale}", "content_{$this->locale}", 'thumbnail', 'slug'])
                ->where('active', true)
                ->where("title_{$this->locale}", '!=', '')
                ->latest('published_at')
                ->take(5)
                ->get();

            return $news->toArray();
        });

        $newsCollection = News::hydrate($rawData);

        return [
            'mainNews' => $newsCollection->first(),
            'sideNews' => $newsCollection->slice(1, 4),
        ];
    }

    public function getAdvantages()
    {
        $rawData = Cache::remember("advantages_{$this->locale}", $this->cacheDuration, function () {
            return Advantage::query()
                ->select(['id', 'active', 'sort', "title_{$this->locale}", "text_{$this->locale}", 'thumbnail'])
                ->where('active', true)
                ->orderBy('sort')
                ->limit(6)
                ->get()
                ->toArray();
        });

        return Advantage::hydrate($rawData);
    }

    public function getAds()
    {
        $rawData = Cache::remember("ads", $this->cacheDuration, function () {
            return Ad::query()->limit(6)->orderBy('position')->get()->toArray();
        });

        return Ad::hydrate($rawData);
    }

    public function getPhotoGallery()
    {
        $rawData = Cache::remember("photoGallery", $this->cacheDuration, function () {
            return PhotoGallery::query()->limit(10)->get()->toArray();
        });

        return PhotoGallery::hydrate($rawData);
    }

    public function getMission()
    {
        $rawData = Cache::remember("mission", $this->cacheDuration, function () {
            $data = DB::table('text_widgets')->where('key', 'mission')->first();
            return $data ? (array) $data : null;
        });

        return $rawData ? (object) $rawData : null;
    }

    public function getStatistics()
    {
        $rawData = Cache::remember("statistics_{$this->locale}", $this->cacheDuration, function () {
            return DB::table('statistics')
                ->select(['value', "description_{$this->locale} as description"])
                ->get()
                ->keyBy('value')
                ->map(fn($item) => (array) $item)
                ->toArray();
        });

        return collect($rawData)->map(fn($item) => (object) $item);
    }

    public function getOpportunitiesBlock()
    {
        $rawData = Cache::remember("opportunities_block", $this->cacheDuration, function () {
            $data = DB::table('text_widgets')->where('key', 'opportunities_block')->first();
            return $data ? (array) $data : null;
        });

        return $rawData ? (object) $rawData : null;
    }

    public function getResourcesBlock()
    {
        $rawData = Cache::remember("resources_block", $this->cacheDuration, function () {
            $data = DB::table('text_widgets')->where('key', 'resources_block')->first();
            return $data ? (array) $data : null;
        });

        return $rawData ? (object) $rawData : null;
    }

    public function getResources()
    {
        $rawData = Cache::remember("resources", $this->cacheDuration, function () {
            return OtherResource::query()
                ->where('active', true)
                ->orderBy('position')
                ->get()
                ->toArray();
        });

        return OtherResource::hydrate($rawData);
    }

    public function getPartners()
    {
        $rawData = Cache::remember("partners", $this->cacheDuration, function () {
            return Partner::query()->get()->toArray();
        });

        return Partner::hydrate($rawData);
    }

    public function getFaq()
    {
        $rawData = Cache::remember("faq_{$this->locale}", $this->cacheDuration, function () {
            return DB::table('faqs')
                ->where('language', $this->locale)
                ->orderBy('sort')
                ->get()
                ->map(fn($item) => (array) $item)
                ->toArray();
        });

        return collect($rawData)->map(fn($item) => (object) $item);
    }

    public function getModal()
    {
        $rawData = Cache::remember("modal", $this->cacheDuration, function () {
            $data = DB::table('text_widgets')
                ->where('key', 'modal')
                ->where('active', true)
                ->first();
            return $data ? (array) $data : null;
        });

        return $rawData ? (object) $rawData : null;
    }
}