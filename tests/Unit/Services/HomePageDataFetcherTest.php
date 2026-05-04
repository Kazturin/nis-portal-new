<?php

namespace Tests\Unit\Services;

use App\Models\Ad;
use App\Models\Advantage;
use App\Models\News;
use App\Models\OtherResource;
use App\Models\Partner;
use App\Models\PhotoGallery;
use App\Models\User;
use App\Services\Page\HomePageDataFetcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HomePageDataFetcherTest extends TestCase
{
    use RefreshDatabase;

    protected HomePageDataFetcher $fetcher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fetcher = new HomePageDataFetcher();
        Cache::flush();
        
        $user = User::factory()->create(['id' => 1]);
        $this->be($user);
    }

    public function test_get_news_returns_hydrated_models()
    {
        News::factory()->count(5)->create(['active' => true]);

        $data = $this->fetcher->getNews();

        $this->assertNotNull($data['mainNews']);
        $this->assertInstanceOf(News::class, $data['mainNews']);
        $this->assertCount(4, $data['sideNews']);
    }

    public function test_get_advantages_returns_hydrated_models()
    {
        Advantage::factory()->count(3)->create(['active' => true]);

        $advantages = $this->fetcher->getAdvantages();

        $this->assertCount(3, $advantages);
        $this->assertInstanceOf(Advantage::class, $advantages->first());
    }

    public function test_get_ads_returns_hydrated_models()
    {
        Ad::factory()->count(2)->create();

        $ads = $this->fetcher->getAds();

        $this->assertCount(2, $ads);
        $this->assertInstanceOf(Ad::class, $ads->first());
    }

    public function test_get_photo_gallery_returns_hydrated_models()
    {
        $alumniPageId = DB::table('alumni_pages')->insertGetId([
            'title_kk' => 'Alumni KK',
            'title_ru' => 'Alumni RU',
            'content_kk' => json_encode([]),
            'content_ru' => json_encode([]),
            'slug' => 'alumni-test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PhotoGallery::factory()->count(3)->create([
            'page_id' => $alumniPageId,
            'photo' => 'photos/test.png'
        ]);

        $gallery = $this->fetcher->getPhotoGallery();

        $this->assertCount(3, $gallery);
        $this->assertInstanceOf(PhotoGallery::class, $gallery->first());
    }

    public function test_get_mission_returns_object()
    {
        DB::table('text_widgets')->insert([
            'key' => 'mission',
            'title_kk' => 'Our Mission',
            'title_ru' => 'Наша миссия',
            'title_en' => 'Our Mission EN',
            'content_kk' => json_encode([]),
            'content_ru' => json_encode([]),
            'content_en' => json_encode([]),
            'active' => true
        ]);

        $mission = $this->fetcher->getMission();

        $this->assertNotNull($mission);
        $this->assertEquals('Our Mission', $mission->title_kk);
    }

    public function test_get_statistics_returns_collection_of_objects()
    {
        DB::table('statistics')->insert([
            'value' => '100',
            'description_kk' => 'Description KK',
            'description_ru' => 'Description RU',
            'description_en' => 'Description EN'
        ]);

        $stats = $this->fetcher->getStatistics();

        $this->assertCount(1, $stats);
        $this->assertEquals('100', $stats->first()->value);
    }

    public function test_get_resources_returns_hydrated_models()
    {
        OtherResource::factory()->count(2)->create(['active' => true]);

        $resources = $this->fetcher->getResources();

        $this->assertCount(2, $resources);
        $this->assertInstanceOf(OtherResource::class, $resources->first());
    }

    public function test_get_partners_returns_hydrated_models()
    {
        Partner::factory()->count(2)->create();

        $partners = $this->fetcher->getPartners();

        $this->assertCount(2, $partners);
        $this->assertInstanceOf(Partner::class, $partners->first());
    }

    public function test_get_faq_returns_collection_of_objects()
    {
        DB::table('faqs')->insert([
            'question' => 'Q?',
            'answer' => 'A!',
            'language' => app()->getLocale(),
            'sort' => 1
        ]);

        $faq = $this->fetcher->getFaq();

        $this->assertCount(1, $faq);
        $this->assertEquals('Q?', $faq->first()->question);
    }

    public function test_get_opportunities_block_returns_object()
    {
        DB::table('text_widgets')->insert([
            'key' => 'opportunities_block',
            'title_kk' => 'Opp KK',
            'title_ru' => 'Opp RU',
            'title_en' => 'Opp EN',
            'content_kk' => json_encode([]),
            'content_ru' => json_encode([]),
            'content_en' => json_encode([]),
            'active' => true
        ]);

        $block = $this->fetcher->getOpportunitiesBlock();

        $this->assertNotNull($block);
        $this->assertEquals('Opp KK', $block->title_kk);
    }

    public function test_get_resources_block_returns_object()
    {
        DB::table('text_widgets')->insert([
            'key' => 'resources_block',
            'title_kk' => 'Res KK',
            'title_ru' => 'Res RU',
            'title_en' => 'Res EN',
            'content_kk' => json_encode([]),
            'content_ru' => json_encode([]),
            'content_en' => json_encode([]),
            'active' => true
        ]);

        $block = $this->fetcher->getResourcesBlock();

        $this->assertNotNull($block);
        $this->assertEquals('Res KK', $block->title_kk);
    }

    public function test_get_modal_returns_object()
    {
        DB::table('text_widgets')->insert([
            'key' => 'modal',
            'title_kk' => 'Modal KK',
            'title_ru' => 'Modal RU',
            'title_en' => 'Modal EN',
            'content_kk' => json_encode([]),
            'content_ru' => json_encode([]),
            'content_en' => json_encode([]),
            'active' => true
        ]);

        $modal = $this->fetcher->getModal();

        $this->assertNotNull($modal);
        $this->assertEquals('Modal KK', $modal->title_kk);
    }
}
