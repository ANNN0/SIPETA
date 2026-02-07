@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Kupon</h3>
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
                        <div class="text-tiny">Kupon</div>
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
                    <a class="tf-button style-1 w208" href="{{ route('admin.coupon.add') }}"><i class="icon-plus"></i>Add
                        new</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive" style="overflow: visible !important;">
                        @if (Session::has('status'))
                            <p class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Cart Value</th>
                                    <th>Tanggal Kedaluwarsa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>{{ $coupon->type }}</td>
                                        <td>
                                            @if ($coupon->type == 'fixed')
                                                Rp{{ number_format($coupon->value, 0, ',', '.') }}
                                            @else
                                                {{ $coupon->value }}%
                                            @endif
                                        </td>
                                        <td>Rp{{ number_format($coupon->cart_value, 0, ',', '.') }}</td>
                                        <td>{{ $coupon->expiry_date }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn-action-dots" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.coupon.edit', ['id' => $coupon->id]) }}">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item text-danger delete-item"
                                                            data-name="{{ $coupon->code }}" data-type="Coupon"
                                                            data-action="{{ route('admin.coupon.delete', ['id' => $coupon->id]) }}">
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
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    <x-table-pagination :paginator="$coupons" />
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
