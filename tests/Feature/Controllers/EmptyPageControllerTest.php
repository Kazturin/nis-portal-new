<?php

namespace Tests\Feature\Controllers;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Tests\Traits\SeedsMandatoryWidgets;

class EmptyPageControllerTest extends TestCase
{
    use RefreshDatabase, SeedsMandatoryWidgets;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.guards.ldap' => ['driver' => 'session', 'provider' => 'users']]);
        Cache::flush();
        $this->seedMandatoryWidgets();
        
        $user = User::factory()->create(['id' => 1]);
        $this->be($user, 'ldap');
    }

    public function test_index_returns_view_for_existing_page()
    {
        $page = Page::factory()->create([
            'slug' => 'empty-test-page',
            'active' => true,
        ]);

        $response = $this->get("/kk/pages/{$page->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('empty_page.index');
        $response->assertViewHas('page', function ($viewPage) use ($page) {
            return $viewPage->id === $page->id;
        });
    }

    public function test_index_aborts_for_non_existent_page()
    {
        // Even if route model binding is used, the controller has an explicit check
        $response = $this->get('/kk/pages/non-existent-slug');

        $response->assertStatus(404);
    }
}
