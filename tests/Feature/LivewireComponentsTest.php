<?php

namespace Tests\Feature;

use App\Livewire\LanguageSelector;
use App\Livewire\NewsComponent;
use App\Livewire\ProductRequestsModal;
use App\Livewire\Statistics;
use App\Models\News;
use App\Models\Statistic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireComponentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_language_selector_renders_and_changes_language()
    {
        Livewire::test(LanguageSelector::class)
            ->assertStatus(200)
            ->call('changeLanguage', 'en')
            ->assertSet('currentLanguage', 'en')
            ->assertDispatched('language-changed');

        $this->assertEquals('en', session('locale'));
    }

    public function test_news_component_renders()
    {
        News::factory()->create([
            'active' => true,
            'published_at' => now()->subDay(),
        ]);

        Livewire::test(NewsComponent::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.news-component');
    }

    public function test_product_requests_modal_renders()
    {
        Livewire::test(ProductRequestsModal::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.product-requests-modal');
    }

    public function test_statistics_component_renders_and_selects_item()
    {
        Statistic::factory()->count(2)->create();

        $component = Livewire::test(Statistics::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.statistics');

        // Assuming there are items, select the second one (index 1)
        $component->call('selectItem', 1)
            ->assertStatus(200);
    }
}
