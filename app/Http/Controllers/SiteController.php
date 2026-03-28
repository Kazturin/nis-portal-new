<?php

namespace App\Http\Controllers;

use App\Services\Page\HomePageDataFetcher;
use Illuminate\Support\Facades\Cache;

class SiteController extends Controller
{
    protected $dataFetcher;

    public function __construct(HomePageDataFetcher $dataFetcher)
    {
        $this->dataFetcher = $dataFetcher;
    }

    public function __invoke()
    {
        $locale = app()->getLocale();
        $cacheKey = "homepage_html_{$locale}";

        $html = Cache::remember($cacheKey, now()->addDays(1), function () {
            $newsData = $this->dataFetcher->getNews();

            return view("site.index", [
                'mainNews' => $newsData['mainNews'],
                'sideNews' => $newsData['sideNews'],
                'advantages' => $this->dataFetcher->getAdvantages(),
                'ads' => $this->dataFetcher->getAds(),
                'photoGallery' => $this->dataFetcher->getPhotoGallery(),
                'mission' => $this->dataFetcher->getMission(),
                'statistics' => $this->dataFetcher->getStatistics(),
                'opportunities_block' => $this->dataFetcher->getOpportunitiesBlock(),
                'resources_block' => $this->dataFetcher->getResourcesBlock(),
                'resources' => $this->dataFetcher->getResources(),
                'partners' => $this->dataFetcher->getPartners(),
                'faq' => $this->dataFetcher->getFaq(),
                'modal' => $this->dataFetcher->getModal(),
            ])->render();
        });

        return response($html);
    }
}

