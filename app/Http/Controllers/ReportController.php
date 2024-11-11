<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Expence;
use App\Models\OrderService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function expence()
    {
        $expences = Expence::with('expenceCategory')->get();
        return view('report.expence',compact('expences'));
    }
    public function sale()
    {
        $orders = Orders::with('orderService')->get();
        return view('report.sales',compact('orders'));
    }
    public function detail($id)
    {
        $orders = OrderService::where('order_id', $id)->get();
        return view('report.saleDetail',compact('orders'));


    }
}
