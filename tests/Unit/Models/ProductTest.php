<?php

namespace Tests\Unit\Models;

use App\Models\Product\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_cache_is_invalidated_on_save()
    {
        Cache::shouldReceive('forget')->with('products')->atLeast()->once();
        
        $product = Product::factory()->create([
            'title_kk' => 'Product KK',
            'active' => true,
        ]);

        $product->title_kk = 'Updated Product';
        $product->save();
    }

    public function test_cache_is_invalidated_on_delete()
    {
        $product = Product::factory()->create();

        Cache::shouldReceive('forget')->with('products')->once();
        
        $product->delete();
    }

    public function test_get_menu_url()
    {
        $product = Product::factory()->make(['slug' => 'test-product']);
        $url = $product->getMenuUrl('kk');
        $this->assertStringContainsString('/kk/product/test-product', $url);
    }

    public function test_product_relations()
    {
        $product = Product::factory()->create();
        
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $product->comments());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class, $product->formSchema());
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $product->requests());
    }
}
