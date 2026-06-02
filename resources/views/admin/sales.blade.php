@extends('layouts.dashboard')
@section('contents')

<main class="dashboard-container container-fluid p-5" id="dash-main">

    <div class="d-flex justify-content-between mb-4">
        <div>
            <h2 class="fw-bold">Sales Record</h2>
            <p class="text-muted">List Of Sales</p>
        </div>
        <div class="text-muted">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->format('l, F d, Y') }}
        </div>
    </div>

    <ul class="nav nav-tabs mb-4 " id="salesTab">
        <li class="nav-item">
            <button class="nav-link" style="background-color: #ff69b4" data-bs-toggle="tab" data-bs-target="#monthly-tab">
                <i class="fa-solid fa-calendar-days me-1"></i> Monthly
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link"  style="background-color: #ff69b4" data-bs-toggle="tab" data-bs-target="#all-tab">
                <i class="fa-solid fa-list me-1"></i> All Sales
            </button>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane fade show active" id="monthly-tab">

            <form method="GET" action="{{ route('admin.sales') }}" class="d-flex gap-2 align-items-end mb-4">
                <div>
                    <label class="form-label mb-1 small fw-semibold">Month</label>
                    <select name="month" class="form-select">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label mb-1 small fw-semibold">Year</label>
                    <select name="year" class="form-select">
                        @foreach(range(now()->year, now()->year - 4) as $y)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-pink">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                </div>
            </form>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <p class="text-muted small mb-1">
                                {{ DateTime::createFromFormat('!m', $selectedMonth)->format('F') }} {{ $selectedYear }}
                            </p>
                            <h4 class="fw-bold">₱{{ number_format($monthlyTotal, 2) }}</h4>
                            <span class="text-muted small">Total Sales</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <p class="text-muted small mb-1">
                                {{ DateTime::createFromFormat('!m', $selectedMonth)->format('F') }} {{ $selectedYear }}
                            </p>
                            <h4 class="fw-bold">{{ $orderCount }}</h4>
                            <span class="text-muted small">Total Orders</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-hover sales-table w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Item</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                            <tr>
                                <td>{{ $sale->order_id }}</td>
                                <td>{{ $sale->customer_name }}</td>
                                <td>{{ $sale->item_name }}</td>
                                <td>{{ $sale->payment_method }}</td>
                                <td class="sales-total">₱{{ number_format($sale->total_amount, 2) }}</td>
                                <td>{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No sales found for {{ DateTime::createFromFormat('!m', $selectedMonth)->format('F') }} {{ $selectedYear }}.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="all-tab">

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <p class="text-muted small mb-1">All Time</p>
                            <h4 class="fw-bold">₱{{ number_format($allSalesTotal, 2) }}</h4>
                            <span class="text-muted small">Total Sales</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <p class="text-muted small mb-1">All Time</p>
                            <h4 class="fw-bold">{{ $allOrderCount }}</h4>
                            <span class="text-muted small">Total Orders</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-hover sales-table w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Item</th>
                                <th>Payment</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allSales as $sale)
                            <tr>
                                <td>{{ $sale->order_id }}</td>
                                <td>{{ $sale->customer_name }}</td>
                                <td>{{ $sale->item_name }}</td>
                                <td>{{ $sale->payment_method }}</td>
                                <td class="sales-total">₱{{ number_format($sale->total_amount, 2) }}</td>
                                <td>{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No sales records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    if (params.has('month') || params.has('year')) {
        const monthTab = document.querySelector('[data-bs-target="#monthly-tab"]');
        bootstrap.Tab.getOrCreateInstance(monthTab).show();
    }
});
</script>

@endsection