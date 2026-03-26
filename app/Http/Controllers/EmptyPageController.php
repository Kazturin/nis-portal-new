<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class EmptyPageController extends Controller
{
    public function index(Request $request, string $locale, Page $page)
    {
        if (!$page->exists) {
            abort(404);
        }
        return view('empty_page.index', compact('page'));
    }
}
