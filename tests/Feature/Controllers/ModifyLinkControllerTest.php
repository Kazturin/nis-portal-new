<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ModifyLinkControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.guards.ldap' => ['driver' => 'session', 'provider' => 'users']]);
    }

    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/modify-link?url=http://example.com');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_is_redirected_to_modified_url()
    {
        $user = new \stdClass();
        $user->mail = ['user@nis.edu.kz'];

        $guardMock = \Mockery::mock();
        $guardMock->shouldReceive('check')->andReturn(true);
        $guardMock->shouldReceive('user')->andReturn($user);

        \Illuminate\Support\Facades\Auth::shouldReceive('guard')
            ->with('ldap')
            ->andReturn($guardMock);

        $response = $this->get('/modify-link?url=http://service');

        // It should redirect to http://service.nis.edu.kz
        $response->assertRedirect('http://service.nis.edu.kz');
    }
}
