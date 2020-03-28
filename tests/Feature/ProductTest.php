<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    // *** index ***

    /** @test */
    public function guest_cannot_list_products()
    {
        $this->json('GET', '/api/products')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    /** @test */
    public function user_can_list_products()
    {
        $this->signIn();

        $user = auth()->user();

        factory(Product::class, 2)->create();

        $products = Product::orderBy('id')
            ->get();

        $expectedData = $products->toArray();

        $this->json('GET', '/api/products?sort=id')
            ->assertStatus(200)
            ->assertJson([
                'data' => $expectedData,
                'links' => [
                    'first' => env('APP_URL') . '/api/products?page=1',
                    'last' => env('APP_URL') . '/api/products?page=1',
                    'prev' => null,
                    'next' => null
                ],
                'meta' => [
                    'current_page' => 1,
                    'from' => 1,
                    'last_page' => 1,
                    'path' => env('APP_URL') . '/api/products',
                    'per_page' => 10,
                    'to' => $products->count(),
                    'total' => $products->count(),
                ],
            ]);
    }

    /** @test */
    public function user_can_search_products_by_name()
    {
        $this->signIn();

        $q_name = 'bbb';

        $product_1 = factory(Product::class)->create(['name' => 'aaa-1']);
        $product_2 = factory(Product::class)->create(['name' => 'bbb-1']);
        $product_3 = factory(Product::class)->create(['name' => 'bbb-2']);
        $product_4 = factory(Product::class)->create(['name' => 'ccc-1']);

        $expectedData = [
            [
                'id' => $product_2->id,
            ],
            [
                'id' => $product_3->id,
            ],
        ];

        $this->json('GET', "/api/products?name={$q_name}")
            ->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => $expectedData,
            ]);
    }

    // *** show ***

    /** @test */
    public function guest_cannot_view_a_product()
    {
        $this->json('GET', '/api/products/1')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    /** @test */
    public function not_found_products_return_404()
    {
        $this->signIn();

        $this->json('GET', '/api/produdcts/9999')
            ->assertStatus(404);
    }

    /** @test */
    public function user_can_view_a_product()
    {
        $this->signIn();

        $product = factory(Product::class)->create();

        $expectedData = $product->toArray();

        $this->json('GET', "/api/products/{$product->id}")
            ->assertStatus(200)
            ->assertJson([
                'data' => $expectedData,
            ]);
    }

    // *** store ***

    /** @test */
    public function guest_cannot_create_a_product()
    {
        $this->json('POST', '/api/products')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    /**  @test */
    public function create_a_product_requires_valid_fields()
    {
        $this->signIn();

        $data = [];

        $this->json('POST', '/api/products', $data)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function user_can_create_a_product()
    {
        $this->signIn();

        $data = factory(Product::class)->raw();

        $this->json('POST', '/api/products', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                ],
            ]);

        $this->assertDatabaseHas('products', $data);
    }

    // *** update ***

    /** @test */
    public function guest_cannot_update_a_product()
    {
        $this->json('PATCH', '/api/products/1')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    /**  @test */
    public function update_a_product_requires_valid_fields()
    {
        $this->signIn();

        $product = factory(Product::class)->create();

        $data = [];

        $this->json('PATCH', "/api/products/{$product->id}", $data)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'name' => [
                        'The name field is required.'
                    ],
                ],
            ]);
    }

    /** @test */
    public function user_can_submit_update_with_no_changes()
    {
        $this->signIn();

        $product = factory(Product::class)->create();

        $data = [
            'name' => $product->name,
            'description' => $product->description,
            'expiry_date' => $product->expiry_date,
        ];

        $this->json('PATCH', "/api/products/{$product->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                ],
            ]);

        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function user_can_update_a_product()
    {
        $this->signIn();

        $product = factory(Product::class)->create();

        $data = factory(Product::class)->raw();

        $this->json('PATCH', "/api/products/{$product->id}", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                ],
            ]);

        $this->assertDatabaseHas('products', $data);
    }

    // *** destroy ***

    /** @test */
    public function guest_cannot_delete_a_product()
    {
        $this->json('DELETE', '/api/products/1')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    /** @test */
    public function authorized_user_can_delete_a_product()
    {
        $this->signIn();

        $product = factory(Product::class)->create();

        $this->json('DELETE', "/api/products/{$product->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
