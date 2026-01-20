@extends('layouts.admin')

@section('content')
    <style>
        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Detail Pesanan</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.admin') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders') }}">
                            <div class="text-tiny">Pesanan</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Detail Pesanan</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Details</h5>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.orders') }}">Back</a>
                </div>
                <div class="table-responsive">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-bordered table-striped table-transaction">
                        <tr>
                            <th>Order No</th>
                            <td>{{ $order->id }}</td>
                            <th>Mobile</th>
                            <td>{{ $order->phone }}</td>
                            <th>Zip Code</th>
                            <td>{{ $order->zip }}</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{ $order->created_at }}</td>
                            <th>Delivered Date</th>
                            <td>{{ $order->delivered_date }}</td>
                            <th>Canceled Date</th>
                            <td>{{ $order->canceled_date }}</td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td colspan="5">
                                @if ($order->status == 'delivered')
                                    <span class="badge bg-success">Terkirim</span>
                                @elseif($order->status == 'canceled')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @elseif($order->status == 'approved')
                                    <span class="badge bg-info">Disetujui</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge bg-primary">Diproses</span>
                                @elseif($order->status == 'dalam_perjalanan')
                                    <span class="badge bg-info">Dalam Perjalanan</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @else
                                    <span class="badge bg-warning">Dipesan</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Items</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Region</th>
                                <th class="text-center">Organic Status</th>
                                <th class="text-center">Return Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $item)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('uploads/products/thumbnails') . '/' . $item->product->image }}"
                                                alt="{{ $item->product->name }}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}"
                                                target="_blank" class="body-title-2">{{ $item->product->name }}</a>
                                        </div>
                                    </td>
                                    <td class="text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->quantity }} @if ($item->unit_symbol)
                                            <span class="text-muted small">{{ $item->unit_symbol }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->product->SKU }}</td>
                                    <td class="text-center">{{ $item->product->category->name }}</td>
                                    <td class="text-center">
                                        {{ $item->product->region ? $item->product->region->name : 'N/A' }}</td>
                                    <td class="text-center">
                                        @if ($item->product->organic_status == 'Organik')
                                            <span class="badge bg-success">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"
                                                    style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                                    <path
                                                        d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.66-2.11c.11-.37.49-.59.88-.49.39.09.64.45.56.86L7 23.2l1.32.37A3.13 3.13 0 0012 21.5c0-.44.08-.88.25-1.29l.09-.25c.06-.15.14-.29.24-.42l1.12-1.5c.19-.26.3-.57.34-.88l.15-1.16c.03-.27.11-.53.24-.77l1.28-2.32c.12-.22.27-.42.44-.6l1.79-1.93c.19-.21.42-.38.67-.51l1.91-.93c.18-.09.35-.21.51-.35l1.7-1.43c.3-.25.47-.62.47-1.01V4.5c0-.83-.67-1.5-1.5-1.5H20c-.36 0-.68.16-.89.41L17 8z" />
                                                </svg>
                                                Organik
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"
                                                    style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                                    <path
                                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                                </svg>
                                                Non-Organik
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->rstatus == 0 ? 'No' : 'Yes' }}</td>
                                    <td class="text-center">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    <x-table-pagination :paginator="$orderItems" />
                </div>
            </div>

            <div class="wg-box">
                <h5>Shipping Address</h5>
                <div class="address-card">
                    <div class="address-item">
                        <span class="label">Name:</span>
                        <span class="value">{{ $order->name }}</span>
                    </div>
                    <div class="address-item">
                        <span class="label">Address:</span>
                        <span class="value">{{ $order->address }}</span>
                    </div>
                    <div class="address-item">
                        <span class="label">Locality:</span>
                        <span class="value">{{ $order->locality }}</span>
                    </div>
                    <div class="address-item">
                        <span class="label">City, Country:</span>
                        <span class="value">{{ $order->city }}, {{ $order->country }}</span>
                    </div>
                    <div class="address-item">
                        <span class="label">Landmark:</span>
                        <span class="value">{{ $order->landmark }}</span>
                    </div>
                    <div class="address-item">
                        <span class="label">Zip Code:</span>
                        <span class="value">{{ $order->zip }}</span>
                    </div>
                    <div class="address-item">
                        <span class="label">Mobile:</span>
                        <span class="value">{{ $order->phone }}</span>
                    </div>
                </div>
            </div>

            <div class="wg-box">
                <h5>Transactions</h5>
                <table class="table table-striped table-bordered table-transaction">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            <th>Tax</th>
                            <td>Rp {{ number_format($order->tax, 0, ',', '.') }}</td>
                            <th>Discount</th>
                            <td>Rp {{ number_format($order->discount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <th>Payment Mode</th>
                            <td>{{ $transaction ? $transaction->mode : 'N/A' }}</td>
                            <th>Status</th>
                            <td>
                                @if ($transaction && $transaction->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($transaction && $transaction->status == 'declined')
                                    <span class="badge bg-danger">Declined</span>
                                @elseif($transaction && $transaction->status == 'refunded')
                                    <span class="badge bg-secondary">Refunded</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="wg-box mt-5">
                <h5>Update Order Status</h5>
                <form action="{{ route('admin.order.status.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->id }}" />
                    <div class="row">
                        <div class="col-md-3">
                            <div class="select">
                                <select id="order_status" name="order_status">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                        Pending (Menunggu)
                                    </option>
                                    <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>
                                        Ordered (Dipesan)
                                    </option>
                                    <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>
                                        Approved (Disetujui)
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                        Processing (Diproses)
                                    </option>
                                    <option value="dalam_perjalanan"
                                        {{ $order->status == 'dalam_perjalanan' ? 'selected' : '' }}>
                                        Dalam Perjalanan
                                    </option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                        Delivered (Terkirim)
                                    </option>
                                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>
                                        Canceled (Dibatalkan)
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary tf-button w208">Update Status</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('.cancel-order').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to cancel this order?",
                    type: "warning",
                    buttons: ["No", "Yes"],
                    confirmButtonColor: "#dc3545",
                }).then(function(result) {
                    if (result) {
                        form.submit();
                    }
                });
            });
        })
    </script>
@endpush
