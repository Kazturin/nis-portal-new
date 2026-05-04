<?php

namespace Tests\Unit\Models;

use App\Models\Ad;
use App\Models\Advantage;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\Statistic;
use App\Models\OtherResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SmallModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_ad_model()
    {
        $ad = Ad::factory()->make([
            'banner_ru' => 'banners/ru.jpg',
            'link_ru' => 'https://example.com'
        ]);
        app()->setLocale('ru');
        $this->assertEquals('/storage/banners/ru.jpg', $ad->getBanner());
        $this->assertEquals('https://example.com', $ad->getLink());
        
        $ad->banner_ru = null;
        $ad->link_ru = null;
        $this->assertNull($ad->getBanner());
        $this->assertEquals('#', $ad->getLink());
    }

    public function test_advantage_model()
    {
        $advantage = Advantage::factory()->make(['thumbnail' => 'icons/adv.png']);
        $this->assertEquals('/storage/icons/adv.png', $advantage->getThumbnail());
        
        $advantage->thumbnail = null;
        $this->assertEquals('/img/no_image.webp', $advantage->getThumbnail());
    }

    public function test_faq_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        
        $faq = Faq::factory()->create([
            'language' => 'ru',
            'question' => 'Q',
            'answer' => 'A'
        ]);
        $this->assertEquals('Q', $faq->question);
        
        $faq->update(['question' => 'Q2']);
        $faq->delete();
    }

    public function test_partner_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        
        $partner = Partner::factory()->create(['logo' => 'logos/p.png']);
        $this->assertEquals('/storage/logos/p.png', $partner->getLogo());
        
        $partner->delete();
    }

    public function test_statistic_model()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        
        $stat = Statistic::factory()->create(['description_ru' => 'Stat']);
        $this->assertEquals('Stat', $stat->description_ru);
        
        $stat->update(['description_ru' => 'Stat2']);
    }

    public function test_other_resource_model()
    {
        $res = OtherResource::factory()->make([
            'title_ru' => 'Res',
            'link' => 'http://res.com',
            'icon' => 'icons/res.png'
        ]);
        app()->setLocale('ru');
        $this->assertEquals('Res', $res->title_ru);
        $this->assertEquals('/storage/icons/res.png', $res->getThumbnail());
        
        $res->icon = null;
        $this->assertEquals('/img/logo.svg', $res->getThumbnail());
    }

    public function test_cache_invalidation_on_ad_save()
    {
        Cache::shouldReceive('forget')->atLeast()->once();
        $ad = Ad::factory()->create();
        $ad->active = false;
        $ad->save();
    }
}
