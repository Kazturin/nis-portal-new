<?php
namespace App\Services\Page;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Cache;

class PageService
{
  protected static $requestCache = [];

  /**
   * Returns the full menu tree for a specific position (cached as array for stability).
   */
  public function getMenuTree(int $position = Menu::POSITION_HEADER)
  {
    $locale = app()->getLocale();
    $cacheKey = "menu_tree_{$position}_{$locale}";

    if (isset(self::$requestCache[$cacheKey])) {
      return self::$requestCache[$cacheKey];
    }

    $data = Cache::remember($cacheKey, 86400, function () use ($position) {
      $query = Menu::with([
        'page',
        'product:id,slug,menu_id', // Always include foreign key for partial selects
        'children' => function ($q) {
          $q->with([
            'page',
            'product:id,slug,menu_id',
            'children' => function ($c) {
              $c->with([
                'page',
                'product:id,slug,menu_id',
                'children' => function ($l) {
                  $l->with([
                    'page',
                    'product:id,slug,menu_id',
                    'children' => function ($depth5) {
                      $depth5->with(['page', 'product:id,slug,menu_id'])
                        ->where('active', true)
                        ->orderBy('sort');
                    }
                  ])
                    ->where('active', true)
                    ->orderBy('sort');
                }
              ])->where('active', true)->orderBy('sort');
            }
          ])->where('active', true)->orderBy('sort');
        },
        'parent'
      ])
        ->where(["active" => true, 'parent_id' => NULL, 'position' => $position])
        ->orderBy('sort');

      return $query->get()->toArray();
    });

    $tree = $this->hydrateMenu($data);
    self::$requestCache[$cacheKey] = $tree;

    return $tree;
  }

  public function accordionMenu(Page $page)
  {
    $topParentId = $page->getTopParentMenu();
    if (!$topParentId)
      return collect();

    // Use the global header tree and find the relevant branch
    $fullMenu = $this->getMenuTree(Menu::POSITION_HEADER);
    $rootItem = $fullMenu->firstWhere('id', $topParentId);

    return $rootItem ? $rootItem->children : collect();
  }

  public function topMenu(int $parentMenuId)
  {
    if (!$parentMenuId)
      return collect();

    $fullMenu = $this->getMenuTree(Menu::POSITION_HEADER);

    // Recursive search for the item in memory
    $findInTree = function ($items, $id) use (&$findInTree) {
      foreach ($items as $item) {
        if ($item->id == $id)
          return $item;
        if ($item->children && $item->children->isNotEmpty()) {
          $found = $findInTree($item->children, $id);
          if ($found)
            return $found;
        }
      }
      return null;
    };

    $parentItem = $findInTree($fullMenu, $parentMenuId);

    if ($parentItem && $parentItem->children) {
      return $parentItem->children->filter(function ($item) {
        // Must be at least level 3 (have a parent with parent_id != null) 
        // and have no children (as per original topMenu logic)
        return $item->parent_id !== null && $item->children->isEmpty();
      });
    }

    return collect();
  }

  /**
   * Enhanced hydration: restores ALL relations and sets parent in memory
   */
  private function hydrateMenu($data, $parentModel = null)
  {
    if (empty($data) || !is_array($data))
      return collect();

    $models = [];
    foreach ($data as $itemData) {
      $childrenData = $itemData['children'] ?? [];
      $pageData = $itemData['page'] ?? null;
      $productData = $itemData['product'] ?? null;

      // Extract and remove relations from primary data array
      unset($itemData['children'], $itemData['page'], $itemData['product'], $itemData['parent']);

      $model = new Menu();
      $model->setRawAttributes($itemData, true);
      $model->exists = true;

      // Set parent in memory (0 queries!)
      if ($parentModel) {
        $model->setRelation('parent', $parentModel);
      }

      // Recursively hydrate children, passing current model as parent
      // Set relations as proper collections/models (always set even if null to prevent lazy loading)
      $model->setRelation('children', $this->hydrateMenu($childrenData, $model));

      $pageModel = null;
      if ($pageData) {
        $pageModel = new Page();
        $pageModel->setRawAttributes($pageData, true);
        $pageModel->exists = true;
      }
      $model->setRelation('page', $pageModel);

      $productModel = null;
      if ($productData) {
        $productModel = new Product();
        $productModel->setRawAttributes($productData, true);
        $productModel->exists = true;
      }
      $model->setRelation('product', $productModel);

      $models[] = $model;
    }

    return collect($models);
  }
}
