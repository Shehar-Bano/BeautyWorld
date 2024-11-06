<?php

namespace App\Http\Controllers;

use App\Models\Expence;
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
        
        return view('report.sales');
    }
}
