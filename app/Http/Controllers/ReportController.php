<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Expence;
use App\Models\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function expence()
    {
        $expences = Expence::with('expenceCategory')->get();
        return view('report.expence', compact('expences'));
    }
    public function sale()
    {
        $orders = Orders::with('orderService')->get();
        return view('report.sales', compact('orders'));
    }
    public function detail($id)
    {
        $orders = OrderService::where('order_id', $id)->get();
        return view('report.saleDetail', compact('orders'));
    }
    public function balanceSheet()
    {
        $expenses = Expence::select('created_at as date', 'price as debit')
            ->get();
            // Fetch paid orders (only credits) with necessary fields
        $orders = Orders::where('status', 'paid')
            ->select('date', 'total_payment as credit')
            ->get();
        // Merge
        $entries = collect($expenses->toArray())->merge($orders->toArray());
        // dd($entries);
        // Initialize the balance
        $balance = 0;
    $entries = $entries->map(function ($entry) use (&$balance) {
        // Ensure that 'debit' and 'credit' keys are present in each entry
        $entry['debit'] = $entry['debit'] ?? 0;
        $entry['credit'] = $entry['credit'] ?? 0;

        // Calculate running balance
        $balance += $entry['credit'] - $entry['debit'];
        $entry['balance'] = $balance;

        return $entry;
    });

    // Pass the data to the view
    return view('balance_Sheet', [
        'entries' => $entries,
        'totalDebit' => $entries->sum('debit'),
        'totalCredit' => $entries->sum('credit'),
        'finalBalance' => $balance,
    ]);
    }
}
