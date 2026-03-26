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
use Illuminate\Support\Facades\Http;
use Str;

class TestController extends Controller
{

    public function index(?string $locale=null)
    {
        return view("test.index");
    }

}
