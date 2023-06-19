<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminCanCreateProduct()
    {
        Storage::fake('local');
        $response = $this->post(route('v1.product.create'), [
            'name' => 'Fancy Dress',
            'slug' => 'fancy-dress',
            'price' => 200,
            'description' => 'Details of a fancy dress',
            'long_description' => 'A very very long description',
            'photo' => UploadedFile::fake()->image('product.jpg'),
        ])->assertCreated();

        $product = $response->baseResponse->original->toArray();

        unset($product['created_at']);
        unset($product['updated_at']);
        $product['price'] = 20000;

        $this->assertDatabaseHas('products', $product);

        $this->assertDatabaseHas('product_variants', [
            'product_id' => $product['id'],
            'name' => $product['name'],
            'quantity' => 1,
        ]);

        Storage::disk('local')
            ->assertExists('public/images/products/'.$product['photo']);
    }
}