<?php

namespace Tests\Unit\Models;

use App\Models\Page;
use App\Models\User;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_pages_relation()
    {
        $user = User::factory()->create();
        $page = Page::factory()->create(['created_by' => $user->id]);

        $this->assertTrue($user->pages->contains($page));
        $this->assertEquals(1, $user->pages()->count());
    }

    public function test_can_access_panel()
    {
        $user = User::factory()->make();
        $panel = Mockery::mock(Panel::class);
        
        $this->assertTrue($user->canAccessPanel($panel));
    }
}
