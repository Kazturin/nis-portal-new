<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the homepage or an invalid page behaves correctly.
     */
    public function test_non_existent_page_returns_404(): void
    {
        $response = $this->get('/ru/pages/non-existent-page-slug');

        $response->assertStatus(404);
    }
}
