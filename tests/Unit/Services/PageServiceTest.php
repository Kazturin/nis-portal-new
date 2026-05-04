<?php

namespace Tests\Unit\Services;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Product\Product;
use App\Services\Page\PageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Mockery;

class PageServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PageService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PageService();
        Cache::flush();
        
        $user = \App\Models\User::factory()->create(['id' => 1]);
        $this->be($user);
        
        // Clear static cache
        $reflection = new \ReflectionClass(PageService::class);
        $property = $reflection->getProperty('requestCache');
        $property->setValue(null, []);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        
        // Clear static cache
        $reflection = new \ReflectionClass(PageService::class);
        $property = $reflection->getProperty('requestCache');
        $property->setValue(null, []);
    }

    public function test_get_menu_tree_returns_correct_structure()
    {
        // Create root menu
        $root = Menu::factory()->create(['position' => Menu::POSITION_HEADER, 'parent_id' => null, 'sort' => 1]);
        // Create child menu
        $child = Menu::factory()->create(['parent_id' => $root->id, 'sort' => 1]);
        // Create page for child
        $page = Page::factory()->create(['menu_id' => $child->id]);

        $tree = $this->service->getMenuTree(Menu::POSITION_HEADER);

        $this->assertCount(1, $tree);
        $this->assertEquals($root->id, $tree->first()->id);
        $this->assertCount(1, $tree->first()->children);
        $this->assertEquals($child->id, $tree->first()->children->first()->id);
        $this->assertNotNull($tree->first()->children->first()->page);
    }

    public function test_get_menu_tree_is_cached()
    {
        Menu::factory()->create(['position' => Menu::POSITION_HEADER]);
        
        $cacheKey = "menu_tree_" . Menu::POSITION_HEADER . "_" . app()->getLocale();
        
        $this->service->getMenuTree(Menu::POSITION_HEADER);
        
        $this->assertTrue(Cache::has($cacheKey));
    }

    public function test_accordion_menu_returns_children_of_top_parent()
    {
        $root = Menu::factory()->create(['position' => Menu::POSITION_HEADER, 'parent_id' => null]);
        $child = Menu::factory()->create(['parent_id' => $root->id]);
        $page = Page::factory()->create();
        
        // Mock getTopParentMenu to return root id
        $pageModel = $this->getMockBuilder(Page::class)
            ->onlyMethods(['getTopParentMenu'])
            ->getMock();
        $pageModel->method('getTopParentMenu')->willReturn($root->id);

        $accordion = $this->service->accordionMenu($pageModel);

        $this->assertCount(1, $accordion);
        $this->assertEquals($child->id, $accordion->first()->id);
    }

    public function test_top_menu_returns_filtered_children()
    {
        $root = Menu::factory()->create(['position' => Menu::POSITION_HEADER]);
        $level2 = Menu::factory()->create(['parent_id' => $root->id]);
        $level3 = Menu::factory()->create(['parent_id' => $level2->id]); // level 3, no children

        $topMenu = $this->service->topMenu($level2->id);

        $this->assertCount(1, $topMenu);
        $this->assertEquals($level3->id, $topMenu->first()->id);
    }

    public function test_hydrate_menu_restores_relations()
    {
        $data = [
            [
                'id' => 1,
                'title_kk' => 'Root',
                'children' => [
                    ['id' => 2, 'title_kk' => 'Child', 'children' => []]
                ],
                'page' => ['id' => 10, 'title_kk' => 'Page 10', 'slug' => 'p10'],
                'product' => ['id' => 20, 'title_kk' => 'Product 20', 'slug' => 'p20']
            ]
        ];

        $service = new PageService();
        $method = new \ReflectionMethod(PageService::class, 'hydrateMenu');
        $method->setAccessible(true);
        
        $result = $method->invoke($service, $data);
        
        $this->assertCount(1, $result);
        $root = $result->first();
        $this->assertCount(1, $root->children);
        $this->assertEquals($root, $root->children->first()->parent);
        $this->assertInstanceOf(Page::class, $root->page);
        $this->assertInstanceOf(Product::class, $root->product);
    }

    public function test_hydrate_menu_returns_empty_on_invalid_data()
    {
        $service = new PageService();
        $method = new \ReflectionMethod(PageService::class, 'hydrateMenu');
        $method->setAccessible(true);
        
        $this->assertTrue($method->invoke($service, null)->isEmpty());
        $this->assertTrue($method->invoke($service, [])->isEmpty());
    }

    public function test_top_menu_filters_correctly()
    {
        // Mock getMenuTree to return a structure
        $child1 = Menu::factory()->make(['id' => 2, 'parent_id' => 1]);
        $child1->setRelation('children', collect());
        
        $child2 = Menu::factory()->make(['id' => 3, 'parent_id' => 1]);
        $grandChild = Menu::factory()->make(['id' => 4, 'parent_id' => 3]);
        $child2->setRelation('children', collect([$grandChild]));
        
        $root = Menu::factory()->make(['id' => 1, 'parent_id' => null]);
        $root->setRelation('children', collect([$child1, $child2]));

        $service = Mockery::mock(PageService::class)->makePartial();
        $service->shouldReceive('getMenuTree')->andReturn(collect([$root]));

        $result = $service->topMenu(1);
        
        // Should only contain child1 because child2 has children
        $this->assertCount(1, $result);
        $this->assertEquals(2, $result->first()->id);
    }
}
