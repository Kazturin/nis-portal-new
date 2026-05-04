<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\Localization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_it_sets_locale_from_url_segment()
    {
        $request = Request::create('/ru/some-page', 'GET');
        
        $middleware = new Localization();
        $middleware->handle($request, function () {
            $this->assertEquals('ru', App::getLocale());
        });
    }

    public function test_it_sets_locale_from_session_if_not_in_url()
    {
        Session::put('locale', 'kk');
        $request = Request::create('/some-page', 'GET');

        $middleware = new Localization();
        $middleware->handle($request, function () {
            $this->assertEquals('kk', App::getLocale());
        });
    }

    public function test_it_defaults_to_config_locale_if_nothing_specified()
    {
        $request = Request::create('/some-page', 'GET');
        $defaultLocale = config('app.locale');

        $middleware = new Localization();
        $middleware->handle($request, function () use ($defaultLocale) {
            $this->assertEquals($defaultLocale, App::getLocale());
        });
    }
}
