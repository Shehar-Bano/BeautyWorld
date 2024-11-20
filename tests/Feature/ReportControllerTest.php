<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Orders;
use App\Models\Expence;
use App\Models\OrderService;
use App\Models\ExpenceCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_expence_view_displays_expenses()
    {
        $expenceCategory = ExpenceCategory::factory()->create();
        Expence::factory()->create(['expence_category_id' => $expenceCategory->id]);

        $response = $this->get(route('expence.report'));
        $response->assertStatus(200)
                 ->assertViewIs('report.expence')
                 ->assertViewHas('expences');
    }

    public function test_sale_view_displays_sales()
    {
        $order = Orders::factory()->has(OrderService::factory()->count(3))->create();

        $response = $this->get(route('sales.report'));
        $response->assertStatus(200)
                 ->assertViewIs('report.sales')
                 ->assertViewHas('orders');
    }

    public function test_detail_view_displays_order_details()
    {
        $order = Orders::factory()->create();
        $orderService = OrderService::factory()->create(['order_id' => $order->id]);

        $response = $this->get(route('detail.sales', ['id' => $order->id]));
        $response->assertStatus(200)
                 ->assertViewIs('report.saleDetail')
                 ->assertViewHas('orders');
    }

    public function test_balance_sheet_view_displays_correct_data()
    {
        Expence::factory()->create(['price' => 100]);
        Orders::factory()->create(['status' => 'paid', 'total_payment' => 200]);

        $response = $this->get(route('balanceSheet'));
        $response->assertStatus(200)
                 ->assertViewIs('balance_Sheet')
                 ->assertViewHasAll(['entries', 'totalDebit', 'totalCredit', 'finalBalance']);
    }

}

