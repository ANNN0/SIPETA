@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All Products</h3>
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
                        <div class="text-tiny">All Products</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name"
                                    tabindex="2" value="{{ request('name') }}" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}"><i class="icon-plus"></i>Add
                        new</a>
                </div>
                <div class="table-responsive">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>SalePrice</th>
                                <th>SKU</th>
                                <th>Kategori</th>
                                <th>Region</th>
                                <th>Unggulan</th>
                                <th>Stok</th>
                                <th>Kuantitas</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products/thumbnails') . '/' . $product->image }}"
                                                alt="{{ $product->name }}"
                                                onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22 viewBox=%220 0 100 100%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22100%22 height=%22100%22/%3E%3Cpath fill=%22%23999%22 d=%22M30,35 L30,65 L45,50 L60,65 L70,55 L70,35 Z M40,45 C40,42.24 42.24,40 45,40 C47.76,40 50,42.24 50,45 C50,47.76 47.76,50 45,50 C42.24,50 40,47.76 40,45 Z%22/%3E%3C/svg%3E'"
                                                style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-right: 12px;">
                                            <div>
                                                <div class="fw-medium">{{ $product->name }}</div>
                                                <div class="text-muted small">{{ $product->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($product->primaryUnitPrice)
                                            {{ number_format($product->primaryUnitPrice->regular_price, 0, ',', '.') }}
                                            <span class="text-tiny">/ {{ $product->primaryUnitPrice->unit->symbol }}</span>
                                        @else
                                            <span class="text-tiny">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->primaryUnitPrice && $product->primaryUnitPrice->sale_price)
                                            {{ number_format($product->primaryUnitPrice->sale_price, 0, ',', '.') }}
                                            <span class="text-tiny">/ {{ $product->primaryUnitPrice->unit->symbol }}</span>
                                        @else
                                            <span class="text-tiny">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->SKU }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->region ? $product->region->name : 'N/A' }}</td>
                                    <td>{{ $product->featured == 0 ? 'No' : 'Yes' }}</td>
                                    <td>{{ $product->stock_status }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn-action-dots" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                {{-- <li>
                                                    <a class="dropdown-item" href="#" target="_blank">
                                                        Detail
                                                    </a>
                                                </li> --}}
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-item text-danger delete-item"
                                                        data-name="{{ $product->name }}" data-type="Product"
                                                        data-action="{{ route('admin.product.delete', ['id' => $product->id]) }}">
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    <x-table-pagination :paginator="$products" />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const type = this.getAttribute('data-type');
                    const action = this.getAttribute('data-action');

                    ModalUtils.showDelete(name, type, function() {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = action;
                        form.innerHTML = '@csrf @method('DELETE')';
                        document.body.appendChild(form);
                        form.submit();
                    });
                });
            });
        });
    </script>
@endpush
