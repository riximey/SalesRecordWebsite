<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today      = Carbon::today();
        $thisMonth  = Carbon::now();

        $totalSalesToday  = Order::whereDate('created_at', $today)->sum('total_amount');
        $totalOrdersToday = Order::whereDate('created_at', $today)->count();

        $totalSalesMonth  = Order::whereMonth('created_at', $thisMonth->month)
                                 ->whereYear('created_at', $thisMonth->year)
                                 ->sum('total_amount');
        $totalOrdersMonth = Order::whereMonth('created_at', $thisMonth->month)
                                 ->whereYear('created_at', $thisMonth->year)
                                 ->count();

        $recentOrders = Order::latest()->take(5)->get();

        $topItems = Order::select(
                        'item_name',
                        DB::raw('SUM(quantity)     as total_qty'),
                        DB::raw('SUM(total_amount) as total_revenue')
                    )
                    ->groupBy('item_name')
                    ->orderByDesc('total_revenue')
                    ->take(5)
                    ->get();

        $monthlySales = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlySales[] = [
                'label'  => $month->format('M Y'),
                'total'  => (float) Order::whereMonth('created_at', $month->month)
                                         ->whereYear('created_at', $month->year)
                                         ->sum('total_amount'),
                'orders' => (int) Order::whereMonth('created_at', $month->month)
                                       ->whereYear('created_at', $month->year)
                                       ->count(),
            ];
        }

        $palette = ['#ff69b4', '#ff1493', '#ffb3d9', '#cc0066', '#ff85c2', '#e91e8c'];
        $rawPayments = Order::select('payment_method', DB::raw('COUNT(*) as count'))
                            ->groupBy('payment_method')
                            ->orderByDesc('count')
                            ->get();

        $paymentBreakdown = $rawPayments->values()->map(function ($row, $idx) use ($palette) {
            return [
                'method' => $row->payment_method,
                'count'  => $row->count,
                'color'  => $palette[$idx % count($palette)],
            ];
        });

        $weeklySales = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $weeklySales[] = [
                'label' => $day->format('D'),   // Mon, Tue …
                'total' => (float) Order::whereDate('created_at', $day)->sum('total_amount'),
            ];
        }

        return view('home', compact(
            'totalSalesToday',
            'totalOrdersToday',
            'totalSalesMonth',
            'totalOrdersMonth',
            'recentOrders',
            'topItems',
            'monthlySales',
            'paymentBreakdown',
            'weeklySales'
        ));
    }
}