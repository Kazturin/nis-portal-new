<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\PageFile;
use App\Services\Page\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FileController extends Controller
{
  public function __construct(
    public PageService $service
  ){}

    public function __invoke(?string $locale, PageFile $pageFile)
    {

    $page = $pageFile->page;

    $parent_menu = $page->getTopParentMenu();

    $accordion_menu = $this->service->accordionMenu($page);


        return view('file.index', compact("accordion_menu","page","pageFile","parent_menu"));
    }
}
