@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Pengajuan Pengembalian</h3>
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
                        <div class="text-tiny">Pengajuan Pengembalian</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search" action="{{ route('admin.returns') }}" method="GET">
                            <fieldset class="name">
                                <input type="text" placeholder="Cari order ID atau nama..." name="search"
                                    value="{{ request('search') }}">
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    @if (Session::has('success'))
                        <p class="alert alert-success">{{ Session::get('success') }}</p>
                    @endif
                    @if (Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Pelanggan</th>
                                <th>Alasan</th>
                                <th>Solusi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($returnRequests as $return)
                                <tr>
                                    <td>{{ $return->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.order.details', $return->order_id) }}"
                                            class="text-primary">
                                            SPT{{ $return->order->created_at->format('ymd') }}{{ str_pad($return->order_id, 4, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="name">
                                            <span class="body-title-2">{{ $return->user->name }}</span>
                                            <div class="text-tiny text-secondary">{{ $return->contact_phone }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $return->reason_label }}</td>
                                    <td>{{ $return->solution_label }}</td>
                                    <td>
                                        @switch($return->status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @break

                                            @case('approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @break

                                            @case('rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @break

                                            @case('completed')
                                                <span class="badge bg-info">Selesai</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>{{ $return->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
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
                                                        href="{{ route('admin.return.details', $return->id) }}">
                                                        <i class="icon-eye me-2"></i> Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.order.details', $return->order_id) }}">
                                                        <i class="icon-file-text me-2"></i> Lihat Order
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Tidak ada pengajuan pengembalian</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        <x-table-pagination :paginator="$returnRequests" />
                    </div>
                </div>
            </div>
        </div>
    @endsection
