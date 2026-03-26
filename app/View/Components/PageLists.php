<?php
namespace App\View\Components;

use App\Models\Page;
use App\Models\PageList;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class PageLists extends Component
{

    public function __construct(
        public ?string $viewType,
        public LengthAwarePaginator $list,
    ) {
    }

    public function render()
    {
        $view = 'components.page-lists.' . $this->viewType;

        return ($this->viewType && view()->exists($view)) ? view($view) : view('components.page-lists.default');
    }
}