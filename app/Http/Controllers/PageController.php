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

        // Eager load everything needed for the page and layout components
        $page->load(['menu.parent.parent', 'banner', 'tabs']);

        $locale = $locale ?? app()->getLocale();

        if ($page->is_protected && !Auth::guard('ldap')->check()) {
            return redirect()->guest(route('login'));
        }

        $files = $page->files()
            ->where("title_{$locale}", '!=', "")
            ->orderBy('position')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $list = $page->pageList()
            ->where("title_{$locale}", '!=', "")
            ->where('active', true)
            ->orderBy('position')
            ->orderBy('date', 'desc')
            ->paginate(12);

        $accordion_menu = $this->service->accordionMenu($page);
        
        $topMenu = null;
        if ($page->menu && $page->menu->parent_id) {
            $topMenu = $this->service->topMenu($page->menu->parent_id);
            if ($topMenu && $topMenu->isEmpty()) {
                $topMenu = null;
            }
        }


        $metaTitle = $page->menu && $page->menu->parent 
            ? $page->menu->parent->{'title_' . $locale} . ' | ' . $page->{'title_' . $locale} 
            : $page->{'title_' . $locale};

        $tabs = $page->tabs;

        return view('page.index', compact('accordion_menu', 'page', 'topMenu', 'files', 'list', 'metaTitle', 'tabs', 'locale'));
    }

    public function listItem(?string $locale, PageList $pageList)
    {
        $pageList->load('page.menu.parent.parent');
        $page = $pageList->page;
        $locale = $locale ?? app()->getLocale();

        $accordion_menu = $this->service->accordionMenu($page);

        $date = $pageList->date;

        $nextPrevQuery = PageList::query()
            ->where("title_{$locale}", '!=', "")
            ->where('page_id', $page->id)
            ->where('id', '!=', $pageList->id);

        if ($date) {
            $next = (clone $nextPrevQuery)
                ->where('date', '<', $date)
                ->orderBy('date', 'desc')
                ->first();

            $prev = (clone $nextPrevQuery)
                ->where('date', '>', $date)
                ->orderBy('date', 'asc')
                ->first();
        } else {
            $next = (clone $nextPrevQuery)
                ->where('position', '>=', $pageList->position)
                ->orderBy('position', 'asc') // Fixed order for next
                ->first();

            $prev = (clone $nextPrevQuery)
                ->where('position', '<=', $pageList->position)
                ->orderBy('position', 'desc') // Fixed order for prev
                ->first();
        }

        $metaTitle = $page->menu && $page->menu->parent 
            ? $page->menu->parent->{'title_' . app()->getLocale()} . ' | ' . $pageList->{'title_' . app()->getLocale()} 
            : $pageList->{'title_' . app()->getLocale()};

        return view('page.list-item', compact("pageList", "accordion_menu", "page", "next", "prev", "metaTitle"));
    }

}
