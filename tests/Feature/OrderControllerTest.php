<?php

namespace Tests\Feature;

use App\Events\StockUpdatedEvent;
use App\Models\Ingredient;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Event::fake();

        /*
         * because we only test a task not a production one
         * I depend on some ids when seeding so i truncated the table to keep the ids as it
         * */
        Schema::disableForeignKeyConstraints();
        Ingredient::truncate();
        Product::truncate();
        DB::table('ingredient_product')->truncate();
        Schema::enableForeignKeyConstraints();

        $this->seed(DatabaseSeeder::class);
    }

    /** @test */
    public function it_can_create_an_order_successfully()
    {
        //arrange
        $payload = [
            'products' => [
                [
                    'product_id' => 1,
                    'quantity' => 2,
                ]
            ]
        ];

        //act
        $response = $this->postJson('/api/order', $payload);

        //assert
        $response->assertCreated();

        $this->assertDatabaseHas('orders', ['id' => $response->json('data.id')]);
    }

    /** @test */
    public function test_stock_alert_is_triggered_at_fifty_percent()
    {
        //arrange

        // Create ingredient with stock just above 50%
        $ingredient = Ingredient::where('name', 'Beef')->first();
        $ingredient->update([
            'stock' => $ingredient->alert_threshold + 0.151, // Just enough for one more burger
        ]);

        $payload = [
            'products' => [
                [
                    'product_id' => 1,
                    'quantity' => 1,
                ]
            ]
        ];

        //act
        $this->postJson('/api/order', $payload);

        //assert
        Event::assertDispatched(StockUpdatedEvent::class);
    }

    /** @test */
    public function it_updates_ingredient_stock_after_order()
    {

        //arrange

        // Initial stock amounts
        $beefInitial = Ingredient::where('name', 'Beef')->first()->stock_quantity;
        $cheeseInitial = Ingredient::where('name', 'Cheese')->first()->stock_quantity;
        $onionInitial = Ingredient::where('name', 'Onion')->first()->stock_quantity;

        $payload = [
            'products' => [
                [
                    'product_id' => 1, // Burger
                    'quantity' => 2,
                ]
            ]
        ];

        //act

        $this->postJson('/api/order', $payload);

        //assert

        // Assert stock was reduced correctly (2 burgers)
        $this->assertEquals(
            $beefInitial - (0.150 * 2), // 150g * 2 burgers
            Ingredient::where('name', 'Beef')->first()->stock_quantity
        );

        $this->assertEquals(
            $cheeseInitial - (0.030 * 2), // 30g * 2 burgers
            Ingredient::where('name', 'Cheese')->first()->stock_quantity
        );

        $this->assertEquals(
            $onionInitial - (0.020 * 2), // 20g * 2 burgers
            Ingredient::where('name', 'Onion')->first()->stock_quantity
        );
    }

    /** @test */
    public function it_fails_when_product_not_found()
    {
        $payload = [
            'products' => [
                [
                    'product_id' => 999,
                    'quantity' => 1,
                ]
            ]
        ];

        $response = $this->postJson('/api/order', $payload);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_validates_request_payload()
    {
        $invalidPayloads = [
            [
                'payload' => ['products' => []],
                'status' => 422
            ],
            [
                'payload' => ['products' => [['quantity' => 1]]],
                'status' => 422
            ],
            [
                'payload' => ['products' => [['product_id' => 1]]],
                'status' => 422
            ],
            [
                'payload' => ['products' => [['product_id' => 'invalid', 'quantity' => 1]]],
                'status' => 422
            ],
            [
                'payload' => ['products' => [['product_id' => 1, 'quantity' => 'invalid']]],
                'status' => 422
            ]
        ];

        foreach ($invalidPayloads as $test) {
            $response = $this->postJson('/api/order', $test['payload']);
            $response->assertStatus($test['status']);
        }
    }



}
