<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\Faq;
use App\Models\News;
use App\Models\Ad;
use App\Models\OtherResource;
use App\Models\Partner;
use App\Models\PhotoGallery;
use App\Services\Page\HomePageDataFetcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Str;

class SiteController extends Controller
{
  protected $dataFetcher;

    public function __construct(HomePageDataFetcher $dataFetcher)
    {
        $this->dataFetcher = $dataFetcher;
    }

    public function __invoke()
    {
      
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
        ]);
    }
}
