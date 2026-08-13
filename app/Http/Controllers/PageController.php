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
use Illuminate\Support\Facades\Cache;

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

        $pageCacheKey = "full_page_html_{$page->id}_{$locale}_" . $request->get('page', 1);

        $html = Cache::tags(['pages', "page_{$page->id}"])->rememberForever($pageCacheKey, function () use ($page, $locale) {
            $page->load(['menu.parent.parent', 'banner', 'tabs']);

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

            $metaTitle = $page->menu && $page->menu->parent
                ? $page->menu->parent->{'title_' . $locale} . ' | ' . $page->{'title_' . $locale}
                : $page->{'title_' . $locale};

            return view('page.index', compact('accordion_menu', 'page', 'files', 'list', 'metaTitle', 'locale'))->render();
        });

        return response($html);
    }

    public function listItem(?string $locale, PageList $pageList)
    {
        if (!$pageList->active) {
            abort(404);
        }

        $locale = $locale ?? app()->getLocale();
        $cacheKey = "full_list_item_html_{$pageList->id}_{$locale}";

        $html = Cache::tags(['pages', "page_{$pageList->page_id}"])->rememberForever($cacheKey, function () use ($pageList, $locale) {
            $pageList->load('page.menu.parent.parent');
            $page = $pageList->page;

            $accordion_menu = $this->service->accordionMenu($page);

            $date = $pageList->date;

            $nextPrevQuery = PageList::query()
                ->where("title_{$locale}", '!=', "")
                ->where('page_id', $page->id)
                ->where('active', true)
                ->where('id', '!=', $pageList->id);

            if ($date) {
                $next = (clone $nextPrevQuery)
                    ->where('date', '<', $date)
                    ->where('active', true)
                    ->orderBy('date', 'desc')
                    ->first();

                $prev = (clone $nextPrevQuery)
                    ->where('date', '>', $date)
                    ->where('active', true)
                    ->orderBy('date', 'asc')
                    ->first();
            } else {
                $next = (clone $nextPrevQuery)
                    ->where('position', '>=', $pageList->position)
                    ->where('active', true)
                    ->orderBy('position', 'asc')
                    ->first();

                $prev = (clone $nextPrevQuery)
                    ->where('position', '<=', $pageList->position)
                    ->where('active', true)
                    ->orderBy('position', 'desc')
                    ->first();
            }

            $metaTitle = $page->menu && $page->menu->parent
                ? $page->menu->parent->{'title_' . $locale} . ' | ' . $pageList->{'title_' . $locale}
                : $pageList->{'title_' . $locale};

            return view('page.list-item', compact("pageList", "accordion_menu", "page", "next", "prev", "metaTitle"))->render();
        });

        return response($html);
    }
}
