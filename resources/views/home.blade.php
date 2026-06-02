@extends('layouts.dashboard')

@section('contents')

<div class="container-fluid py-4 px-4">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color:#cc0066;">Dashboard</h4>
            <p class="text-muted small mb-0">Welcome back! Here's what's happening today.</p>
        </div>
        <div class="d-flex align-items-center gap-2 text-muted small border rounded-3 px-3 py-2 bg-white">
            <i class="fas fa-calendar-alt" style="color:#ff69b4;"></i>
            {{ now()->format('l, F j, Y') }}
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:15px; background:linear-gradient(135deg,#ff69b4,#ff1493); color:white;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-uppercase fw-semibold mb-1" style="font-size:0.7rem;opacity:0.85;letter-spacing:0.07em;">Total Sales Today</p>
                        <h3 class="fw-bold mb-0">₱{{ number_format($totalSalesToday, 2) }}</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:rgba(255,255,255,0.2);">
                        <i class="fas fa-peso-sign"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:15px;border-top:3px solid #ff69b4 !important;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-uppercase fw-semibold text-muted mb-1" style="font-size:0.7rem;letter-spacing:0.07em;">Orders Today</p>
                        <h3 class="fw-bold mb-0" style="color:#333;">{{ $totalOrdersToday }}</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:#fff0f7;color:#ff69b4;">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:15px;border-top:3px solid #ff69b4 !important;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-uppercase fw-semibold text-muted mb-1" style="font-size:0.7rem;letter-spacing:0.07em;">Sales This Month</p>
                        <h3 class="fw-bold mb-0" style="color:#333;">₱{{ number_format($totalSalesMonth, 2) }}</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:#fff0f7;color:#ff69b4;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:15px;border-top:3px solid #ff69b4 !important;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-uppercase fw-semibold text-muted mb-1" style="font-size:0.7rem;letter-spacing:0.07em;">Orders This Month</p>
                        <h3 class="fw-bold mb-0" style="color:#333;">{{ $totalOrdersMonth }}</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:#fff0f7;color:#ff69b4;">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius:15px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="fw-bold mb-0" style="color:#333;">Monthly Revenue</h6>
                            <p class="text-muted small mb-0">Revenue trend — last 6 months</p>
                        </div>
                        <span class="badge rounded-pill px-3 py-2" style="background:#fff0f7;color:#ff69b4;font-size:0.75rem;">
                            ₱{{ number_format(collect($monthlySales)->sum('total'), 2) }} total
                        </span>
                    </div>
                    <canvas id="lineChart" height="110"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:15px;">
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-0" style="color:#333;">Monthly Orders</h6>
                        <p class="text-muted small mb-0">Order volume — last 6 months</p>
                    </div>
                    <canvas id="barChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:15px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-1" style="color:#333;">Payment Methods</h6>
                    <p class="text-muted small mb-3">Breakdown of how customers pay</p>
                    <div style="max-width:240px; margin:0 auto;">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-3">
                        @foreach($paymentBreakdown as $pm)
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle" style="width:10px;height:10px;background:{{ $pm['color'] }};flex-shrink:0;"></div>
                            <span class="small text-muted">{{ $pm['method'] }} ({{ $pm['count'] }})</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-7 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:15px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-1" style="color:#333;">Top Selling Items</h6>
                    <p class="text-muted small mb-3">By total revenue</p>
                    <canvas id="topItemsChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:15px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-1" style="color:#333;">Daily Sales</h6>
                    <p class="text-muted small mb-3">This week's sales per day</p>
                    <canvas id="weekChart" height="200"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm" style="border-radius:15px;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-0" style="color:#333;">Recent Orders</h6>
                    <p class="text-muted small mb-0">Latest 5 transactions</p>
                </div>
                <a href="/admin/orders" class="btn btn-sm rounded-3" style="font-size:0.82rem;border:1.5px solid #ffc0cb;color:#ff69b4;">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-muted small fw-semibold">#</th>
                            <th class="text-muted small fw-semibold">Customer</th>
                            <th class="text-muted small fw-semibold">Item</th>
                            <th class="text-muted small fw-semibold">Payment</th>
                            <th class="text-muted small fw-semibold">Qty</th>
                            <th class="text-muted small fw-semibold">Total</th>
                            <th class="text-muted small fw-semibold">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="text-muted fw-semibold">{{ $order->order_id }}</td>
                            <td class="fw-semibold">{{ $order->customer_name }}</td>
                            <td>{{ $order->item_name }}</td>
                            <td>
                                @php
                                    $pm = strtolower(str_replace(' ', '', $order->payment_method));
                                    $badgeClass = match($pm) {
                                        'card'  => 'bg-success-subtle text-success',
                                        'cash'  => 'bg-warning-subtle text-warning',
                                        'gcash' => 'bg-info-subtle text-info',
                                        default => 'bg-secondary-subtle text-secondary',
                                    };
                                @endphp
                                <span class="badge rounded-pill {{ $badgeClass }} px-3 py-1" style="font-size:0.75rem;">
                                    {{ $order->payment_method }}
                                </span>
                            </td>
                            <td>{{ $order->quantity }}</td>
                            <td class="fw-bold" style="color:#ff69b4;">₱{{ number_format($order->total_amount, 2) }}</td>
                            <td class="text-muted small">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No orders yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script>
    const monthLabels   = @json(collect($monthlySales)->pluck('label'));
    const monthRevenue  = @json(collect($monthlySales)->pluck('total'));
    const monthOrders   = @json(collect($monthlySales)->pluck('orders'));
    const pmLabels      = @json(collect($paymentBreakdown)->pluck('method'));
    const pmCounts      = @json(collect($paymentBreakdown)->pluck('count'));
    const pmColors      = @json(collect($paymentBreakdown)->pluck('color'));
    const itemLabels    = @json(collect($topItems)->pluck('item_name'));
    const itemRevenue   = @json(collect($topItems)->pluck('total_revenue'));
    const weekLabels    = @json(collect($weeklySales)->pluck('label'));
    const weekRevenue   = @json(collect($weeklySales)->pluck('total'));

    const pink      = '#ff69b4';
    const pinkLight = 'rgba(255,105,180,0.18)';
    const pinkMid   = 'rgba(255,105,180,0.7)';
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const lineGrad = lineCtx.createLinearGradient(0, 0, 0, 220);
    lineGrad.addColorStop(0, 'rgba(255,105,180,0.28)');
    lineGrad.addColorStop(1, 'rgba(255,105,180,0)');

    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Revenue',
                data: monthRevenue,
                borderColor: pink,
                backgroundColor: lineGrad,
                borderWidth: 2.5,
                pointBackgroundColor: pink,
                pointRadius: 5,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#999', font: { size: 11 } } },
                y: { grid: { color: '#f5f5f5' }, ticks: { color: '#999', font: { size: 11 },
                    callback: v => '₱' + v.toLocaleString() } }
            }
        }
    });

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Orders',
                data: monthOrders,
                backgroundColor: pinkMid,
                borderColor: pink,
                borderWidth: 1.5,
                borderRadius: 7,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#999', font: { size: 10 } } },
                y: { grid: { color: '#f5f5f5' }, ticks: { color: '#999', font: { size: 10 },
                    stepSize: 1, callback: v => Number.isInteger(v) ? v : '' } }
            }
        }
    });

    new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: pmLabels,
            datasets: [{
                data: pmCounts,
                backgroundColor: pmColors,
                borderWidth: 3,
                borderColor: '#fff',
                hoverOffset: 8,
            }]
        },
        options: {
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed} orders` } }
            }
        }
    });

    new Chart(document.getElementById('topItemsChart'), {
        type: 'bar',
        data: {
            labels: itemLabels,
            datasets: [{
                label: 'Revenue',
                data: itemRevenue,
                backgroundColor: [
                    'rgba(255,105,180,0.85)',
                    'rgba(255,105,180,0.68)',
                    'rgba(255,105,180,0.52)',
                    'rgba(255,105,180,0.38)',
                    'rgba(255,105,180,0.25)',
                ],
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: '#f5f5f5' }, ticks: { color: '#999', font: { size: 10 },
                    callback: v => '₱' + v.toLocaleString() } },
                y: { grid: { display: false }, ticks: { color: '#555', font: { size: 11 } } }
            }
        }
    });

    const weekCtx = document.getElementById('weekChart').getContext('2d');
    const weekGrad = weekCtx.createLinearGradient(0, 0, 0, 180);
    weekGrad.addColorStop(0, 'rgba(255,105,180,0.3)');
    weekGrad.addColorStop(1, 'rgba(255,105,180,0)');

    new Chart(weekCtx, {
        type: 'line',
        data: {
            labels: weekLabels,
            datasets: [{
                label: 'Sales',
                data: weekRevenue,
                borderColor: pink,
                backgroundColor: weekGrad,
                borderWidth: 2,
                pointBackgroundColor: pink,
                pointRadius: 4,
                tension: 0.35,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#999', font: { size: 10 } } },
                y: { grid: { color: '#f5f5f5' }, ticks: { color: '#999', font: { size: 10 },
                    callback: v => '₱' + v.toLocaleString() } }
            }
        }
    });
</script>
@endpush