<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageFile;
use App\Models\PageList;
use App\Models\PageTab;
use App\Services\Page\PageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function __construct(
        public PageService $service
    ) {
    }

    public function index(Request $request, ?string $locale, Page $page)
    {
        if (!$page->exists) {
            abort(404);
        }
        $locale = $locale ?? app()->getLocale();

        if ($page->is_protected && !Auth::guard('ldap')->check()) {
            return redirect()->guest(route('login'));
        }

        $files = PageFile::query()->where("title_{$locale}", '!=', "")->where('page_id', $page->id)->orderBy('position')->orderBy('created_at', 'desc')->paginate(15);

        $list = $page->pageList()->where("title_{$locale}", '!=', "")->where('active', true)->orderBy('position')->orderBy('date', 'desc')->paginate(12);

        $accordion_menu = $this->service->accordionMenu($page);
        $topMenu = $page->menu->parent_id ? $this->service->topMenu($page->menu->parent_id) : null;

        if ($topMenu && $topMenu->empty()) {
            $topMenu = null;
        }


        $metaTitle = $page->menu->parent ? $page->menu->parent->{'title_' . $locale} . ' | ' . $page->{'title_' . $locale} : $page->{'title_' . $locale};

        $tabs = PageTab::query()->where('page_id', $page->id)->get();

        return view('page.index', compact('accordion_menu', 'page', 'topMenu', 'files', 'list', 'metaTitle', 'tabs', 'locale'));
    }

    public function listItem(?string $locale, PageList $pageList)
    {

        $page = $pageList->page;

        $accordion_menu = $this->service->accordionMenu($page);

        $date = $pageList->date;


        if ($date) {
            $next = PageList::query()
                ->where("title_{$locale}", '!=', "")
                ->where('page_id', $page->id)
                ->where('id', '!=', $pageList->id)
                ->where('date', '<', $date)->orderBy('date', 'desc')
                ->limit(1)
                ->first();

            $prev = PageList::query()
                ->where("title_{$locale}", '!=', "")
                ->where('page_id', $page->id)
                ->where('id', '!=', $pageList->id)
                ->where('date', '>', $date)
                ->orderBy('date', 'asc')
                ->limit(1)
                ->first();
        } else {
            $next = PageList::query()
                ->where("title_{$locale}", '!=', "")
                ->where('page_id', $page->id)
                ->where('id', '!=', $pageList->id)
                ->where('position', '>=', $pageList->position)
                ->orderBy('date', 'desc')
                ->limit(1)
                ->first();

            $prev = PageList::query()
                ->where("title_{$locale}", '!=', "")
                ->where('page_id', $page->id)
                ->where('id', '!=', $pageList->id)
                ->where('position', '<=', $pageList->position)
                ->orderBy('date', 'asc')
                ->limit(1)
                ->first();
        }


        $metaTitle = $page->menu->parent ? $page->menu->parent->{'title_' . app()->getLocale()} . ' | ' . $pageList->{'title_' . app()->getLocale()} : $pageList->{'title_' . app()->getLocale()};

        return view('page.list-item', compact("pageList", "accordion_menu", "page", "next", "prev", "metaTitle"));
    }

}
