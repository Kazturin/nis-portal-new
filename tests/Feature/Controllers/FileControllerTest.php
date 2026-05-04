<?php

namespace Tests\Feature\Controllers;

use App\Models\Page;
use App\Models\PageFile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Tests\Traits\SeedsMandatoryWidgets;

class FileControllerTest extends TestCase
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

    public function test_invoke_returns_view_with_file_data()
    {
        $page = Page::factory()->create([
            'active' => true,
        ]);

        $pageFile = PageFile::create([
            'page_id' => $page->id,
            'title_kk' => 'Test File KK',
            'title_ru' => 'Test File RU',
            'title_en' => 'Test File EN',
            'files_kk' => ['files/test.pdf'],
            'files_ru' => ['files/test.pdf'],
            'files_en' => ['files/test.pdf'],
        ]);

        $response = $this->get("/kk/files/{$pageFile->id}");

        $response->assertStatus(200);
        $response->assertViewIs('file.index');
        $response->assertViewHasAll(['accordion_menu', 'page', 'pageFile', 'parent_menu']);
    }
}
