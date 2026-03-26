<?php

namespace App\Http\Controllers;

use App\Models\Product\Product;
use App\Models\Product\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{


    public function index(?string $locale, Product $product)
    {
        $locale = $locale ?? 'kk';
        $metaTitle = $product->{'title_' . $locale};
        // dd($locale);
        $columns = ['id', "title_{$locale}", "content_{$locale}"];

        $product = Product::select($columns)->with(['comments', 'formSchema'])->findOrFail($product->id);

        //  dd($product->formSchema->form_schema);

        return view('product.kiva', compact('product', 'metaTitle', 'locale'));
    }

    public function submitForm(Request $request, Product $product)
    {
        $formSchema = $product->formSchema->form_schema ?? [];

        if (empty($formSchema)) {
            return back()->with('error', 'Форма для данного продукта не настроена.');
        }

        $validationRules = collect($formSchema)->mapWithKeys(function ($field) {
            return [Str::slug($field['name_en'], '_') => 'required|string'];
        })->toArray();

        $validatedData = $request->validate($validationRules);

        if (empty($validatedData)) {
            return back()->with('error', 'Ошибка: поля формы не заполнены.');
        }

        ProductRequest::create([
            'product_id' => $product->id,
            'data' => $validatedData,
        ]);

        return back()->with('success', 'Запрос успешно отправлен!');
    }
}
