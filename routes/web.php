<?php

use App\Http\Controllers\Alumni\AlumniPageController;
use App\Http\Controllers\Auth\LdapLoginController;
use App\Http\Controllers\EmptyPageController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ModifyLinkController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\YoutubeVideosController;
use App\Http\Middleware\Localization;
use App\Models\Product\Product;
use App\Models\Product\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;


Route::post('language', function (Request $request) {
   \Illuminate\Support\Facades\App::setLocale($request->locale);
   session()->put('locale', $request->locale);

   $parsedUrl = parse_url(url()->previous());
   if (isset($parsedUrl['path'])) {
      $path = $parsedUrl['path'];
      $path = preg_replace('/^\/\w{2}\//', '/' . $request->locale . '/', $path);

      $redirectUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $path;
   } else {
      $redirectUrl = '/';
   }
   return redirect()->to($redirectUrl);
})->name('language');

Route::group([
   'prefix' => '{locale?}',
   'where' => ['locale' => '[a-zA-Z]{2}'],
   'middleware' => Localization::class
], function () {
   Route::get('/', SiteController::class);
   Route::get('/page/{page:slug?}', [PageController::class, 'index'])->name('page');
   Route::get('/list/{pageList}', [PageController::class, 'listItem'])->name('list.item');
   Route::get('/files/{pageFile}', FileController::class)->name('files');
   Route::get('/search', SearchController::class)->name('search');

   Route::get('/news', [NewsController::class, 'index'])->name('news');
   Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

   Route::get('/product/{product:slug?}', [ProductController::class, 'index'])->name('product');

   Route::get('pages/{page:slug?}', [EmptyPageController::class, 'index'])->name('empty.page');
   Route::get('/test', [TestController::class, 'index']);
   Route::get('/check-image', [TestController::class, 'index']);

});
Route::post('/products/{product}/form', [ProductController::class, 'submitForm'])->name('product.form.submit');

// Route::get('/login', [LdapLoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LdapLoginController::class, 'login']);
// Route::post('/logout', [LdapLoginController::class, 'logout'])->name('logout');

Route::get('/modify-link', ModifyLinkController::class)->name('modify.link');


Route::post('/check-image/upload', [TestController::class, 'upload'])->name('upload.send');