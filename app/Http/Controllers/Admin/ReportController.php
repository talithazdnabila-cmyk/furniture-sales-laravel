<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $query = Transaction::orderBy('created_at', 'desc');
        
        // Filter berdasarkan tanggal jika disediakan
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        $transactions = $query->get();
        $totalSales = $transactions->sum('grand_total');

        return view('admin.reports.sales', compact(
            'transactions',
            'totalSales',
            'startDate',
            'endDate'
        ));
    }
}
