<?php

namespace Tests\Unit\View\Components;

use App\View\Components\AccordionMenu;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AccordionMenuTest extends TestCase
{
    public function test_find_item()
    {
        $child = (object)['id' => 2, 'children' => []];
        $root = (object)['id' => 1, 'children' => [$child]];
        $menu = collect([$root]);

        $component = new AccordionMenu($menu);

        $this->assertEquals($root, $component->findItem($menu, 1));
        $this->assertEquals($child, $component->findItem($menu, 2));
        $this->assertNull($component->findItem($menu, 3));
        $this->assertNull($component->findItem($menu, null));
    }

    public function test_has_content()
    {
        app()->setLocale('ru');
        $component = new AccordionMenu(collect());

        $itemWithPage = (object)[
            'page' => (object)[], 
            'is_external_link' => false,
            'link_ru' => null,
            'link_kk' => null,
            'link_en' => null,
        ];
        $itemWithLink = (object)[
            'page' => null, 
            'link_ru' => 'http://test.com', 
            'link_kk' => null,
            'link_en' => null,
            'is_external_link' => false
        ];
        $itemExternal = (object)[
            'page' => null, 
            'is_external_link' => true,
            'link_ru' => null,
            'link_kk' => null,
            'link_en' => null,
        ];
        $itemEmpty = (object)[
            'page' => null, 
            'link_ru' => null, 
            'link_kk' => null,
            'link_en' => null,
            'is_external_link' => false
        ];

        $this->assertTrue($component->hasContent($itemWithPage));
        $this->assertTrue($component->hasContent($itemWithLink));
        $this->assertTrue($component->hasContent($itemExternal));
        $this->assertFalse($component->hasContent($itemEmpty));
        $this->assertFalse($component->hasContent(null));
    }

    public function test_is_active_and_expanded()
    {
        $component = new AccordionMenu(
            menu: collect(),
            pageMenu: 1,
            pageParentMenu: 2
        );

        $item1 = (object)['id' => 1];
        $item2 = (object)['id' => 2];
        $item3 = (object)['id' => 3];

        $this->assertTrue($component->isActive($item1));
        $this->assertFalse($component->isActive($item2));

        $this->assertTrue($component->isExpanded($item2));
        $this->assertFalse($component->isExpanded($item1));
    }

    public function test_is_top_level_expanded()
    {
        $component = new AccordionMenu(
            menu: collect(),
            pageParentMenu: 2,
            rootMenu: 3
        );

        $this->assertTrue($component->isTopLevelExpanded((object)['id' => 2]));
        $this->assertTrue($component->isTopLevelExpanded((object)['id' => 3]));
        $this->assertFalse($component->isTopLevelExpanded((object)['id' => 1]));
    }

    public function test_title()
    {
        $item = (object)['title_ru' => 'Title RU', 'title_kk' => 'Title KK'];

        app()->setLocale('ru');
        $componentRu = new AccordionMenu(collect());
        $this->assertEquals('Title RU', $componentRu->title($item));

        app()->setLocale('kk');
        $componentKk = new AccordionMenu(collect());
        $this->assertEquals('Title KK', $componentKk->title($item));
    }

    public function test_flatten_menu_and_drill_down_root()
    {
        $grandChild = (object)[
            'id' => 3, 
            'parent_id' => 2, 
            'children' => [],
            'page' => null,
            'is_external_link' => false,
            'link_ru' => null,
            'link_kk' => null,
            'link_en' => null,
        ];
        $child = (object)[
            'id' => 2, 
            'parent_id' => 1, 
            'children' => [$grandChild], 
            'page' => (object)[], 
            'is_external_link' => false,
            'link_ru' => null,
            'link_kk' => null,
            'link_en' => null,
        ];
        $root = (object)[
            'id' => 1, 
            'parent_id' => null, 
            'children' => [$child], 
            'page' => null, 
            'is_external_link' => false,
            'link_ru' => null,
            'link_kk' => null,
            'link_en' => null,
        ];
        
        $menu = collect([$root]);
        
        // Root has no content, Child has content and children.
        // If we are at GrandChild (id:3), drillDownRoot should be Child (id:2).
        
        app()->setLocale('ru');
        $component = new AccordionMenu($menu, pageMenu: 3);
        
        $this->assertCount(3, $component->allMenuItems);
        $this->assertEquals($child, $component->drillDownItem);
    }
}
