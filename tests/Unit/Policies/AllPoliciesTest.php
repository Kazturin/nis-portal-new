<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\File;

class AllPoliciesTest extends TestCase
{
    public function test_all_policies_view_any_method()
    {
        $policyFiles = File::files(app_path('Policies'));

        foreach ($policyFiles as $file) {
            $policyClass = 'App\\Policies\\' . $file->getFilenameWithoutExtension();

            if (class_exists($policyClass)) {
                $policy = new $policyClass();

                if (method_exists($policy, 'viewAny')) {
                    $userAllowed = \Mockery::mock(User::class)->makePartial();
                    $userAllowed->shouldReceive('hasRole')->andReturn(true);

                    $this->assertTrue($policy->viewAny($userAllowed), "Policy $policyClass should allow access when hasRole is true");

                    $userDenied = \Mockery::mock(User::class)->makePartial();
                    $userDenied->shouldReceive('hasRole')->andReturn(false);

                    $this->assertFalse($policy->viewAny($userDenied), "Policy $policyClass should deny access when hasRole is false");
                }
            }
        }
    }
}
