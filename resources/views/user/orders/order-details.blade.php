@extends('layouts.app')

@section('content')
    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Order Detail</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')
                </div>

                <div class="col-lg-10">
                    <div class="order-details-header">
                        <h3 class="page-subtitle">Detail Pesanan</h3>
                        <a class="back-button" href="{{ route('user.orders') }}">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8 0L9.41 1.41 3.83 7H16v2H3.83l5.58 5.59L8 16 0 8z" />
                            </svg>
                            Back to Orders
                        </a>
                    </div>

                    <div class="wg-box">
                        <h5>Ordered Details</h5>
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
                                    <th>Pin Code</th>
                                    <td>{{ $order->zip }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pesanan</th>
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
                                            <span class="badge bg-success">Delivered</span>
                                        @elseif($order->status == 'canceled')
                                            <span class="badge bg-danger">Canceled</span>
                                        @else
                                            <span class="badge bg-warning">Ordered</span>
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
                                        <th class="text-center">Aksi</th>
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
                                                        <svg width="12" height="12" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                                            style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                                            <path
                                                                d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.66-2.11c.11-.37.49-.59.88-.49.39.09.64.45.56.86L7 23.2l1.32.37A3.13 3.13 0 0012 21.5c0-.44.08-.88.25-1.29l.09-.25c.06-.15.14-.29.24-.42l1.12-1.5c.19-.26.3-.57.34-.88l.15-1.16c.03-.27.11-.53.24-.77l1.28-2.32c.12-.22.27-.42.44-.6l1.79-1.93c.19-.21.42-.38.67-.51l1.91-.93c.18-.09.35-.21.51-.35l1.7-1.43c.3-.25.47-.62.47-1.01V4.5c0-.83-.67-1.5-1.5-1.5H20c-.36 0-.68.16-.89.41L17 8z"
                                                                fill="currentColor" />
                                                        </svg>
                                                        Organik
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <svg width="12" height="12" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                                            style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                                            <path
                                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"
                                                                fill="currentColor" />
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
                    @if ($order->status == 'ordered')
                        <div class="wg-box text-right">
                            <form action="{{ route('user.order.cancel', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_id" value="{{ $order->id }}" />
                                <button type="button" class="btn btn-danger cancel-order">Batalkan Pesanan</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
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
