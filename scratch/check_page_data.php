<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\Page;

$page = Page::whereNotNull('content_ru')->first();
if ($page) {
    echo "ID: " . $page->id . "\n";
    echo "Content RU (type): " . gettype($page->content_ru) . "\n";
    echo "Content RU (value):\n";
    print_r($page->content_ru);
} else {
    echo "No page found with content_ru\n";
}
