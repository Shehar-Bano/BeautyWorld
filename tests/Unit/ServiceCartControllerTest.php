<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Deal;
use App\Models\DealService;
use App\Models\Orders;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str; // Import this
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ServiceCartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Unique identifier for the admin
            [
                'name' => 'Admin User',
                'password' => Hash::make('88888888'), // Set a secure password
                'phone' => '1234567890876',
                'designation' => 'admin',
                'joining_date' => now(),
                'salary' => 100000.00,
                'status' => 'active',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );

        // Run necessary seeding logic or setup here
        User::factory()->create(['designation' => 'worker']);
        ServiceCategory::factory()->count(10)->create();
        Service::factory()->count(20)->create();
        Deal::factory()->count(10)->create();
        DealService::factory()->count(10)->create();
        
    }

    /** @test */
    public function it_can_display_the_cart_index_page()
    {
        


        $response = $this->get(route('cart.index'));
        
        $response->assertStatus(200);
        $response->assertViewHas(['deals', 'providers', 'services']);
    }

    /** @test */
    public function it_can_add_items_to_cart()
    {
        $cartItems = json_encode([
            ['id' => 1, 'type' => 'service'],
            ['id' => 2, 'type' => 'deal']
        ]);

        $response = $this->post(route('cart.add'), [
            'seatNumber' => 'A1',
            'cartItems' => $cartItems,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Items set on hold successfully');

        $this->assertDatabaseHas('carts', ['seat_number' => 'A1']);
        $this->assertDatabaseHas('cart_items', ['cart_id' => Cart::first()->id, 'service_id' => 1]);
        $this->assertDatabaseHas('cart_items', ['cart_id' => Cart::first()->id, 'deal_id' => 2]);
    }

    /** @test */
    public function it_can_update_cart_items()
    {
        $cart = Cart::factory()->create(['seat_number' => 'A2']);
        CartItems::factory()->create(['cart_id' => $cart->id, 'service_id' => 1]);

        $newItems = json_encode([
            ['id' => 2, 'type' => 'service'],
            ['id' => 3, 'type' => 'deal']
        ]);

        $response = $this->post(route('cart.update'), [
            'seatNumber' => 'A2',
            'cartItems' => $newItems,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Cart updated successfully!');

        $this->assertDatabaseMissing('cart_items', ['cart_id' => $cart->id, 'service_id' => 1]);
        $this->assertDatabaseHas('cart_items', ['cart_id' => $cart->id, 'service_id' => 2]);
        $this->assertDatabaseHas('cart_items', ['cart_id' => $cart->id, 'deal_id' => 3]);
    }

    /** @test */
    public function it_can_confirm_an_order_and_generate_a_receipt()
    {
        $user = User::factory()->create(['designation' => 'worker']);
        $cartItems = json_encode([
            ['id' => 1, 'type' => 'service', 'price' => 100],
            ['id' => 2, 'type' => 'deal', 'price' => 150]
        ]);

        $response = $this->post(route('cart.order.confirm'), [
            'provider_id' => $user->id,
            'seatNumber' => 'A1',
            'customerName' => 'John Doe',
            'customerEmail' => 'john.doe@example.com',
            'customerPhone' => '1234567890',
            'cartItems' => $cartItems,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('cart.receipt');
        $response->assertViewHas(['order', 'orderServices']);
    }
}
