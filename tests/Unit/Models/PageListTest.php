<?php

namespace Tests\Unit\Models;

use App\Models\Menu;
use App\Models\Page;
use App\Models\PageList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PageListTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_formatted_date()
    {
        $pageList = PageList::factory()->make(['date' => '2023-10-27']);
        $this->assertEquals('27.10.2023', $pageList->getFormattedDate());

        $pageList->date = null;
        $this->assertEquals(now()->format('d.m.Y'), $pageList->getFormattedDate());
    }

    public function test_get_image_url()
    {
        $pageList = PageList::factory()->make(['image' => 'lists/image.jpg']);
        $this->assertEquals('/storage/lists/image.jpg', $pageList->getImage());

        $pageList->image = 'https://external.com/image.png';
        $this->assertEquals('https://external.com/image.png', $pageList->getImage());

        $pageList->image = null;
        $this->assertNull($pageList->getImage());
    }

    public function test_short_title()
    {
        $pageList = PageList::factory()->make(['title_ru' => 'This is a very long title that should be limited']);
        app()->setLocale('ru');
        $this->assertEquals('This is a ve...', $pageList->shortTitle(12));

        $pageList->title_ru = null;
        $this->assertEquals('', $pageList->shortTitle());
    }

    public function test_get_url()
    {
        $pageList = PageList::factory()->create();
        $this->assertStringContainsString('/list/' . $pageList->id, $pageList->getUrl());
    }

    public function test_attribute_casting_json()
    {
        $content = ['type' => 'doc', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'Hello']]]]];
        $pageList = new PageList();
        $pageList->content_ru = $content;

        // Test setAttribute (it should be stored as JSON string in attributes)
        $this->assertIsString($pageList->getAttributes()['content_ru']);
        $this->assertStringContainsString('Hello', $pageList->getAttributes()['content_ru']);

        // Test getAttribute (it should be decoded back to array)
        $this->assertIsArray($pageList->content_ru);
        $this->assertEquals('Hello', $pageList->content_ru['content'][0]['content'][0]['text']);
    }

    public function test_cache_is_invalidated_on_save()
    {
        Cache::shouldReceive('supportsTags')->andReturn(false);
        Cache::shouldReceive('forget')->atLeast()->once();
        
        $page = Page::factory()->create();
        $pageList = PageList::factory()->create(['page_id' => $page->id]);
        $pageList->title_kk = 'Updated Title';
        $pageList->save();
    }
}
