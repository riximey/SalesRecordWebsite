@extends('layouts.dashboard')

@section('contents')

<main class="container-fluid w-100 p-5" id="order-main">

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="order-head">
            <h2>Manage Orders</h2>
            <p class="text-muted">Organize or view orders</p>
        </div>
        <div class="text-muted">
            <i class="fa-regular fa-calendar"></i>
            <span>{{ now()->format('l, F d, Y') }}</span>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-4">
        <button class="btn receiptaddbtn" style="background-color: rgb(249, 178, 215);" data-bs-toggle="modal" data-bs-target="#receiptModal">
            <i class="fa-solid fa-plus"></i> Add Order
        </button>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0 mt-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->order_id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->item_name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>₱{{ number_format($order->price, 2) }}</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                        <td class="text-center">

                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#viewOrder{{ $order->order_id }}">
                                <i class="fa fa-eye"></i>
                            </button>

                            <button class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteOrder{{ $order->order_id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @foreach($orders as $order)

        <div class="modal fade" id="viewOrder{{ $order->order_id }}" tabindex="-1">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Order #{{ $order->order_id }} – {{ $order->customer_name }}
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $order->item_name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td class="text-end">₱{{ number_format($order->price, 2) }}</td>
                                    <td class="text-end">₱{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Payment:</strong>
                            <span>{{ $order->payment_method }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <strong>Total</strong>
                            <strong>₱{{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteOrder{{ $order->order_id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5>Confirm Delete</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Delete order <strong>#{{ $order->order_id }}</strong> from
                            <strong>{{ $order->customer_name }}</strong>?
                        </p>
                        <form method="POST" action="{{ route('admin.orders.destroy', $order->order_id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Confirm Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

</main>

<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fa-solid fa-receipt"></i> New Order Receipt
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('admin.orders.store') }}">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="customer_name" class="form-control"
                            value="{{ old('customer_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option>Cash</option>
                            <option>GCash</option>
                            <option>Card</option>
                        </select>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input type="text" name="item_name" class="form-control"
                            value="{{ old('item_name') }}" placeholder="e.g. Rose Bouquet" required>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control"
                                value="{{ old('quantity') }}" min="1" placeholder="1" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Price per item (₱)</label>
                            <input type="number" name="price" class="form-control"
                                value="{{ old('price') }}" min="0" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn receiptaddbtn" style="background-color:rgb(249, 178, 215)">Save Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    ['successToast', 'errorToast'].forEach(id => {
        const el = document.getElementById(id);
        if (el) new bootstrap.Toast(el).show();
    });
});
</script>

@endsection