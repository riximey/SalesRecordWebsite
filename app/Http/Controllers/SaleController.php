<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->month ?? now()->month;
        $selectedYear  = $request->year  ?? now()->year;

        $sales = Order::whereMonth('created_at', $selectedMonth)
                    ->whereYear('created_at', $selectedYear)
                    ->orderBy('created_at', 'desc')
                    ->get();

        $monthlyTotal = $sales->sum('total_amount');
        $orderCount   = $sales->count();

        $allSales      = Order::orderBy('created_at', 'desc')->get();
        $allSalesTotal = $allSales->sum('total_amount');
        $allOrderCount = $allSales->count();

        return view('admin.sales', compact(
            'sales', 'monthlyTotal', 'orderCount',
            'selectedMonth', 'selectedYear',
            'allSales', 'allSalesTotal', 'allOrderCount'
        ));
    }
}