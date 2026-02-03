<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();
    $totalSales   = $transactions->sum('grand_total');

    return view('admin.reports.sales', compact(
        'transactions',
        'totalSales'
    ));
    }
}
