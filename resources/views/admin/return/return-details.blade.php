@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Detail Pengajuan Pengembalian</h3>
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
                        <a href="{{ route('admin.returns') }}">
                            <div class="text-tiny">Pengajuan Pengembalian</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Detail</div>
                    </li>
                </ul>
            </div>

            @if (Session::has('success'))
                <div class="alert alert-success mb-3">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger mb-3">{{ Session::get('error') }}</div>
            @endif

            <!-- Return Request Info -->
            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <h5>Informasi Pengajuan</h5>
                    <a class="tf-button style-1 w208" href="{{ route('admin.returns') }}">Kembali</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">ID Pengajuan</th>
                            <td>#{{ $returnRequest->id }}</td>
                            <th width="200">Tanggal Pengajuan</th>
                            <td>{{ $returnRequest->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Order ID</th>
                            <td>
                                <a href="{{ route('admin.order.details', $returnRequest->order_id) }}" class="text-primary">
                                    SPT{{ $returnRequest->order->created_at->format('ymd') }}{{ str_pad($returnRequest->order_id, 4, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <th>Status</th>
                            <td>
                                @switch($returnRequest->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
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
                        </tr>
                        <tr>
                            <th>Alasan Pengembalian</th>
                            <td>{{ $returnRequest->reason_label }}</td>
                            <th>Solusi yang Dipilih</th>
                            <td>{{ $returnRequest->solution_label }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi Masalah</th>
                            <td colspan="3">{{ $returnRequest->description }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Customer Contact -->
            <div class="wg-box">
                <h5>Kontak Pelanggan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="150">Nama</th>
                                <td>{{ $returnRequest->contact_name }}</td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>{{ $returnRequest->contact_phone }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $returnRequest->user->email }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="150">Alamat</th>
                                <td>{{ $returnRequest->sender_address }}</td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td>{{ $returnRequest->sender_city }}, {{ $returnRequest->sender_state }}</td>
                            </tr>
                            <tr>
                                <th>Kode Pos</th>
                                <td>{{ $returnRequest->sender_zip }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Product being returned -->
            <div class="wg-box">
                <h5>Produk yang Dikembalikan</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($returnRequest->order->orderItems as $item)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('uploads/products/thumbnails/' . $item->product->image) }}"
                                                alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="name">
                                            <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}"
                                                target="_blank" class="body-title-2">{{ $item->product->name }}</a>
                                        </div>
                                    </td>
                                    <td class="text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">Rp
                                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total Order:</th>
                                <th class="text-center">Rp
                                    {{ number_format($returnRequest->order->total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Uploaded Photos/Videos -->
            @if ($returnRequest->photos && count($returnRequest->photos) > 0)
                <div class="wg-box">
                    <h5>Bukti Foto/Video</h5>
                    <div class="row g-3">
                        @foreach ($returnRequest->photos as $photo)
                            <div class="col-md-3 col-6">
                                @if (Str::endsWith($photo, ['.mp4', '.mov', '.webm']))
                                    <video src="{{ asset($photo) }}" class="img-fluid rounded"
                                        style="width: 100%; max-height: 200px; background: #f5f5f5;" controls></video>
                                @else
                                    <a href="{{ asset($photo) }}" target="_blank" class="d-block">
                                        <img src="{{ asset($photo) }}" class="img-fluid rounded"
                                            style="width: 100%; max-height: 200px; object-fit: contain; background: #f5f5f5; padding: 8px;">
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Update Status -->
            <div class="wg-box">
                <h5>Update Status Pengajuan</h5>
                <form action="{{ route('admin.return.status.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="return_id" value="{{ $returnRequest->id }}">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label class="body-title mb-10">Status</label>
                            <div class="select">
                                <select name="status" id="status">
                                    <option value="pending" {{ $returnRequest->status == 'pending' ? 'selected' : '' }}>
                                        Menunggu Persetujuan</option>
                                    <option value="approved" {{ $returnRequest->status == 'approved' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="rejected" {{ $returnRequest->status == 'rejected' ? 'selected' : '' }}>
                                        Ditolak</option>
                                    <option value="completed"
                                        {{ $returnRequest->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="body-title mb-10">Catatan Admin (Opsional)</label>
                            <input type="text" name="admin_notes" class="form-control"
                                value="{{ $returnRequest->admin_notes }}" placeholder="Catatan untuk pelanggan...">
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="submit" class="tf-button w-100">Update Status</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
