<?php


namespace Tests\Feature;

use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed');
    }

    /** @test */
    public function it_creates_an_order_and_updates_the_stock_correctly()
    {

        $ingredient1 = Ingredient::find(1);
        $ingredient2 = Ingredient::find(2);
        $data = [
            'products' => [
                ['product_id' => 1, 'quantity' => 2],
                ['product_id' => 2, 'quantity' => 1],
            ]
        ];

        $response = $this->postJson('/api/order', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', ['status' => 'pending']);
        $this->assertDatabaseHas('order_products', ['product_id' => 1, 'quantity' => 2]);

        $ingredient1->refresh();
        $ingredient2->refresh();
        $this->assertEquals(19700, $ingredient1->stock);
        $this->assertEquals(4890, $ingredient2->stock);
    }

    /** @test */
    public function it_throws_an_error_if_stock_is_insufficient_for_order()
    {
        $data = [
            'products' => [
                ['product_id' => 1, 'quantity' => 90000],
                ['product_id' => 2, 'quantity' => 90000],
            ]
        ];

        $response = $this->postJson('/api/order', $data);

        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'Not enough stock for ingredient Beef.',
        ]);
    }
}
