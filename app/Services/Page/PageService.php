<?php
namespace App\Services\Page;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class PageService
{
  protected $pageTopParentMenu;

  // public function __construct()
  // {
  //     $this->pageTopParentMenu = app()->getLocale();
  // }

    public function accordionMenu(Page $page)
    {
      $page_top_parent_menu = $page->getTopParentMenu();

      return  Menu::with([
        'page',
        'children' => function($q){
                  $q->with(['page','children' => function($c){
                                $c->with('page')->where('active',true)->orderBy('sort');
                              }])->where('active',true)->orderBy('sort');
                            }, 
        'parent'])
        ->where(["active"=>true,'parent_id'=>$page_top_parent_menu])
        ->orderBy('sort')
        ->get();

        // return Cache::remember('accordion_menu'.(string)$page_top_parent_menu, 600, function() use($page_top_parent_menu){
        //     return Menu::with([
        //       'page',
        //       'children' => function($q){
        //                 $q->with(['page','children' => function($c){
        //                               $c->with('page')->where('active',true)->orderBy('sort');
        //                             }])->where('active',true)->orderBy('sort');
        //                           }, 
        //       'parent'])
        //       ->where(["active"=>true,'parent_id'=>$page_top_parent_menu])
        //       ->orderBy('sort')
        //       ->get();
        //     }); 
    }

    public function topMenu(int $parentMenu)
    {
      return $parentMenu ? Menu::with(['page'])
         ->whereHas('parent',function($q){
           $q->where('parent_id','!=',NULL);
         })
         ->doesntHave('children')
         ->where("parent_id", $parentMenu)
         ->where('active',true)
         ->orderBy('sort')
         ->get() : NULL;
    }

}

