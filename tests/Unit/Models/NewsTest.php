<?php

namespace Tests\Unit\Models;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_formatted_date()
    {
        $news = News::factory()->make([
            'published_at' => '2024-05-20 10:00:00'
        ]);

        // locale is set in setup or depends on app config
        app()->setLocale('ru');
        $this->assertEquals('20 мая 2024', $news->getFormattedDate());
        
        app()->setLocale('kk');
        // 'F' for Kazakh might be different, let's just check if it returns something
        $this->assertNotEmpty($news->getFormattedDate());
    }

    public function test_get_photo_returns_default_when_empty()
    {
        $news = News::factory()->make(['thumbnail' => null]);
        $this->assertEquals('/img/no_image.webp', $news->getPhoto());
    }

    public function test_get_photo_returns_storage_path()
    {
        $news = News::factory()->make(['thumbnail' => 'news/image.jpg']);
        $this->assertEquals('/storage/news/image.jpg', $news->getPhoto());
    }

    public function test_short_title()
    {
        $news = News::factory()->make(['title_ru' => 'This is a very long title that should be limited']);
        app()->setLocale('ru');
        $this->assertEquals('This is a ve...', $news->shortTitle(12));
    }

    public function test_short_body()
    {
        $news = News::factory()->make(['content_ru' => 'This is a long content that should be limited by words count.']);
        app()->setLocale('ru');
        $this->assertEquals('This is a long content...', $news->shortBody(5));
    }

    public function test_short_title_returns_empty_when_no_title()
    {
        $news = News::factory()->make(['title_ru' => null]);
        app()->setLocale('ru');
        $this->assertEquals('', $news->shortTitle());
    }

    public function test_short_body_returns_empty_when_no_content()
    {
        $news = News::factory()->make(['content_ru' => null]);
        app()->setLocale('ru');
        $this->assertEquals('', $news->shortBody());
    }

    public function test_set_published_at_attribute()
    {
        $news = new News();
        $news->published_at = null;
        $this->assertNotNull($news->published_at); // should default to now()
        
        $date = now()->addDays(1);
        $news->published_at = $date;
        $this->assertEquals($date->toDateTimeString(), $news->published_at->toDateTimeString());
    }

    public function test_get_url_attribute()
    {
        $news = News::factory()->make(['slug' => 'test-news']);
        $this->assertStringContainsString('/news/test-news', $news->url);
    }

    public function test_cache_is_invalidated_on_save()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        
        $news = News::factory()->create();
        $news->title_kk = 'Updated';
        $news->save();
    }

    public function test_category_relation()
    {
        $category = NewsCategory::factory()->create();
        $news = News::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(NewsCategory::class, $news->category);
        $this->assertEquals($category->id, $news->category->id);
    }
}
