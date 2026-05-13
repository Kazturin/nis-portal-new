<?php

namespace Tests\Unit\Models;

use App\Models\Ad;
use App\Models\Advantage;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Statistic;
use App\Models\OtherResource;
use App\Models\PageFile;
use App\Models\TextWidget;
use App\Models\Product\ProductRequest;
use App\Models\Role;
use App\Models\NewsCategory;
use App\Models\PhotoGallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SmallModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_request_model()
    {
        $request = ProductRequest::factory()->create([
            'data' => ['foo' => 'bar']
        ]);
        $this->assertEquals('bar', $request->data['foo']);
        $this->assertNotNull($request->product);
    }

    public function test_role_model()
    {
        $role = Role::factory()->create(['guard_name' => null]);
        $this->assertEquals('web', $role->guard_name);
    }

    public function test_text_widget_model()
    {
        Cache::shouldReceive('supportsTags')->andReturn(false);
        Cache::shouldReceive('forget')->atLeast()->once();
        
        $widget = TextWidget::factory()->create(['key' => 'my_key']);
        $widget->update(['title_ru' => 'New Title']);
        $widget->delete();
    }

    public function test_page_file_model()
    {
        $pageFile = PageFile::factory()->make([
            'file_ru' => 'files/test.pdf',
            'files_ru' => ['files/1.pdf', 'files/2.pdf'],
            'thumbnail' => 'thumbs/file.jpg'
        ]);
        app()->setLocale('ru');

        $this->assertEquals('/storage/files/test.pdf', $pageFile->getFile());
        $this->assertEquals(['/storage/files/1.pdf', '/storage/files/2.pdf'], $pageFile->getFiles());
        $this->assertEquals('/storage/thumbs/file.jpg', $pageFile->getThumbnail());

        $pageFile->thumbnail = null;
        $this->assertEquals('/img/docs.jpg', $pageFile->getThumbnail());
    }

    public function test_ad_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        $ad = Ad::factory()->create([
            'banner_ru' => 'banners/ru.jpg',
            'link_ru' => 'https://example.com',
        ]);
        app()->setLocale('ru');
        $this->assertEquals('/storage/banners/ru.jpg', $ad->getBanner());
        
        $ad->update(['banner_ru' => 'banners/ru2.jpg']);
        $ad->delete();

        // Test null banner on non-persisted model
        $ad2 = Ad::factory()->make(['banner_ru' => null]);
        $this->assertNull($ad2->getBanner());
    }

    public function test_advantage_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        $advantage = Advantage::factory()->create(['thumbnail' => 'icons/adv.png']);
        $this->assertEquals('/storage/icons/adv.png', $advantage->getThumbnail());
        
        $advantage->update(['thumbnail' => 'icons/adv2.png']);
        $advantage->delete();

        // Test null thumbnail on non-persisted model
        $adv2 = Advantage::factory()->make(['thumbnail' => null]);
        $this->assertEquals('/img/no_image.webp', $adv2->getThumbnail());
    }

    public function test_faq_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        $faq = Faq::factory()->create(['language' => 'ru', 'question' => 'Q']);
        $this->assertEquals('Q', $faq->question);
        $faq->update(['question' => 'Q2']);
        $faq->delete();
    }

    public function test_partner_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        $partner = Partner::factory()->create(['logo' => 'logos/p.png']);
        $this->assertEquals('/storage/logos/p.png', $partner->getLogo());
        $partner->update(['logo' => 'logos/p2.png']);
        $partner->delete();
    }

    public function test_statistic_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        $stat = Statistic::factory()->create(['description_ru' => 'Stat']);
        $this->assertEquals('Stat', $stat->description_ru);
        $stat->update(['description_ru' => 'Stat2']);
        $stat->delete();
    }

    public function test_other_resource_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        $res = OtherResource::factory()->create(['title_ru' => 'Res', 'icon' => 'icons/res.png']);
        app()->setLocale('ru');
        $this->assertEquals('Res', $res->title_ru);
        
        $res->update(['icon' => 'icons/res2.png']);
        $res->delete();

        // Test null icon on non-persisted model
        $res2 = OtherResource::factory()->make(['icon' => null]);
        $this->assertEquals('/img/logo.svg', $res2->getThumbnail());
    }

    public function test_news_category_model()
    {
        $cat = NewsCategory::factory()->create([
            'title_kk' => 'C', 'title_ru' => 'C', 'title_en' => 'C'
        ]);
        $this->assertEquals('C', $cat->title_ru);
        $this->assertNotNull($cat->news);
    }

    public function test_photo_gallery_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        
        $alumniPageId = DB::table('alumni_pages')->insertGetId([
            'title_kk' => 'T', 'title_ru' => 'T', 'content_kk' => '{}', 'content_ru' => '{}', 'slug' => 's-' . uniqid()
        ]);

        $photo = PhotoGallery::factory()->create([
            'page_id' => $alumniPageId,
            'photo' => 'photos/1.jpg'
        ]);
        $this->assertEquals('/storage/photos/1.jpg', $photo->getPhoto());
        $photo->update(['photo' => 'photos/2.jpg']);
        $photo->delete();
    }
}
