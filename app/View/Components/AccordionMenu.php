<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class AccordionMenu extends Component
{
    public string $locale;
    public ?object $activeItem;
    public ?object $parentItem;
    public ?object $drillDownItem;

    /** @var array<int, object> Flat map of all menu items keyed by ID */
    public array $allMenuItems;

    /**
     * Create a new component instance.
     *
     * @param  Collection|array  $menu           The hierarchical menu tree
     * @param  int|null          $pageMenu        Current page's menu ID
     * @param  int|null          $rootMenu        Root-level menu ID for expansion
     * @param  int|null          $pageParentMenu  Parent menu ID for expansion state
     */
    public function __construct(
        public Collection|array $menu,
        public ?int $pageMenu = null,
        public ?int $rootMenu = null,
        public ?int $pageParentMenu = null,
    ) {
        $this->locale = app()->getLocale();
        $this->allMenuItems = $this->flattenMenu($this->menu);
        $this->activeItem = $this->findItem($this->menu, $this->pageMenu);
        $this->parentItem = $this->findItem($this->menu, $this->pageParentMenu);
        $this->drillDownItem = $this->findDrillDownRoot($this->pageMenu);
    }

    /**
     * Recursively search for a menu item by its ID.
     */
    public function findItem(Collection|array $items, ?int $id): ?object
    {
        if ($id === null) {
            return null;
        }

        foreach ($items as $item) {
            if ($item->id == $id) {
                return $item;
            }

            if ($item->children && count($item->children) > 0) {
                $found = $this->findItem($item->children, $id);
                if ($found) {
                    return $found;
                }
            }
        }

        return null;
    }

    /**
     * Check whether a menu item has navigable content (page, localized link, or external link).
     */
    public function hasContent(?object $item): bool
    {
        if (!$item) {
            return false;
        }

        return $item->page || $item->{'link_' . $this->locale} || $item->is_external_link;
    }

    /**
     * Check whether a menu item is currently active.
     */
    public function isActive(?object $item): bool
    {
        return $item && $this->pageMenu === $item->id;
    }

    /**
     * Check whether a menu item should be expanded (is parent of current page).
     */
    public function isExpanded(?object $item): bool
    {
        return $item && $this->pageParentMenu === $item->id;
    }

    /**
     * Check whether a top-level menu item should be expanded.
     */
    public function isTopLevelExpanded(?object $item): bool
    {
        return $item && (
            $this->pageParentMenu === $item->id
            || (isset($this->rootMenu) && $this->rootMenu === $item->id)
        );
    }

    /**
     * Get the localized title for a menu item.
     */
    public function title(object $item): string
    {
        return $item->{'title_' . $this->locale} ?? '';
    }

    /**
     * Flatten the menu tree into a keyed array for upward traversal.
     *
     * @return array<int, object>
     */
    private function flattenMenu(Collection|array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $result[$item->id] = $item;

            if ($item->children && count($item->children) > 0) {
                $result = $result + $this->flattenMenu($item->children);
            }
        }

        return $result;
    }

    /**
     * Find the closest ancestor that is a drill-down candidate
     * (has both content and children).
     */
    private function findDrillDownRoot(?int $id): ?object
    {
        if ($id === null || !isset($this->allMenuItems[$id])) {
            return null;
        }

        $item = $this->allMenuItems[$id];
        $pid = $item->parent_id;

        while ($pid && isset($this->allMenuItems[$pid])) {
            $parent = $this->allMenuItems[$pid];

            if ($this->hasContent($parent) && count($parent->children) > 0) {
                return $parent;
            }

            $pid = $parent->parent_id;
        }

        return null;
    }

    /**
     * Get the view that represents the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.accordion-menu');
    }
}
