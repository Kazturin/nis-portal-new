<?php

namespace Tests\Unit\View\Components;

use Tests\TestCase;
use App\View\Components\PageLists;
use Illuminate\Pagination\LengthAwarePaginator;

class PageListsTest extends TestCase
{
    public function test_render_returns_specific_view_when_it_exists()
    {
        $paginator = new LengthAwarePaginator([], 0, 10);
        $component = new PageLists('grid', $paginator);

        $view = $component->render();

        $this->assertEquals('components.page-lists.grid', $view->name());
    }

    public function test_render_returns_default_view_when_specific_does_not_exist()
    {
        $paginator = new LengthAwarePaginator([], 0, 10);
        $component = new PageLists('missing_type_123', $paginator);

        $view = $component->render();

        $this->assertEquals('components.page-lists.default', $view->name());
    }

    public function test_render_returns_default_view_when_type_is_null()
    {
        $paginator = new LengthAwarePaginator([], 0, 10);
        $component = new PageLists(null, $paginator);

        $view = $component->render();

        $this->assertEquals('components.page-lists.default', $view->name());
    }
}
