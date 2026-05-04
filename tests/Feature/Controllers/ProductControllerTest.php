<?php

namespace Tests\Feature\Controllers;

use App\Models\Product\Product;
use App\Models\Product\ProductFormSchema;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Tests\Traits\SeedsMandatoryWidgets;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, SeedsMandatoryWidgets;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.guards.ldap' => ['driver' => 'session', 'provider' => 'users']]);
        Cache::flush();
        $this->seedMandatoryWidgets();
        
        $user = User::factory()->create(['id' => 1]);
        $this->be($user, 'ldap');
    }

    public function test_product_index_returns_successful_response()
    {
        $product = Product::factory()->create([
            'slug' => 'test-product',
            'title_kk' => 'Test Product KK',
            'active' => true,
        ]);
        
        ProductFormSchema::factory()->create([
            'product_id' => $product->id,
        ]);

        $response = $this->get("/kk/product/{$product->slug}");

        $response->assertStatus(200);
        $response->assertSee('Test Product KK');
    }

    public function test_product_submit_form_successfully()
    {
        $product = Product::factory()->create(['active' => true]);
        ProductFormSchema::factory()->create([
            'product_id' => $product->id,
            'form_schema' => [
                ['name_en' => 'Full Name', 'type' => 'text', 'name_kk' => 'Name KK', 'name_ru' => 'Name RU'],
                ['name_en' => 'Email', 'type' => 'email', 'name_kk' => 'Email KK', 'name_ru' => 'Email RU'],
            ]
        ]);

        $response = $this->post(route('product.form.submit', $product), [
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('product_requests', [
            'product_id' => $product->id,
        ]);
    }

    public function test_product_submit_form_validation_error()
    {
        $product = Product::factory()->create(['active' => true]);
        ProductFormSchema::factory()->create([
            'product_id' => $product->id,
            'form_schema' => [
                ['name_en' => 'Full Name', 'type' => 'text', 'name_kk' => 'Name KK', 'name_ru' => 'Name RU'],
            ]
        ]);

        $response = $this->post(route('product.form.submit', $product), [
            // Missing full_name
        ]);

        $response->assertSessionHasErrors(['full_name']);
    }

    public function test_product_submit_form_empty_schema()
    {
        $product = Product::factory()->create(['active' => true]);
        // No ProductFormSchema created

        $response = $this->post(route('product.form.submit', $product), [
            'full_name' => 'John Doe',
        ]);

        $response->assertSessionHas('error', 'Форма для данного продукта не настроена.');
    }

    public function test_product_submit_form_empty_validated_data()
    {
        $product = Product::factory()->create(['active' => true]);
        ProductFormSchema::factory()->create([
            'product_id' => $product->id,
            'form_schema' => [] 
        ]);

        $response = $this->post(route('product.form.submit', $product), []);

        $response->assertSessionHas('error', 'Форма для данного продукта не настроена.');
    }
}
