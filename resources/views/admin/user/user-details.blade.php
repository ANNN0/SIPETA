@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Detail Pengguna</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.admin') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('admin.users') }}">
                            <div class="text-tiny">User</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Detail</div>
                    </li>
                </ul>
                <a href="{{ route('admin.users') }}" class="tf-button style-1 w208">
                    <i class="icon-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="wg-box mt-5">
                <div class="flex items-center justify-between mb-20">
                    <h5 class="mb-0">Informasi Profil</h5>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-3 text-center mb-4 mb-md-0">
                        @if ($user->image)
                            <img src="@cloudinary($user->image, 300, 300, 'fill')" alt="{{ $user->name }}" class="user-profile-image">
                        @else
                            <div class="user-profile-image placeholder">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="row user-detail-list">
                            <div class="col-md-6">
                                <div class="item-detail">
                                    <label>Nama Lengkap</label>
                                    <div class="body-text">{{ $user->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item-detail">
                                    <label>Email Address</label>
                                    <div class="body-text">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item-detail">
                                    <label>Nomor Telepon</label>
                                    <div class="body-text">{{ $user->mobile ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item-detail">
                                    <label>Status Akun</label>
                                    @if ($user->is_blocked)
                                        <span class="badge bg-danger">Blocked</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item-detail">
                                    <label>Tanggal Bergabung</label>
                                    <div class="body-text">{{ $user->created_at->format('d F Y, H:i') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item-detail">
                                    <label>Perubahan Terakhir</label>
                                    <div class="body-text">{{ $user->updated_at->format('d F Y, H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            @if ($user->is_blocked)
                                <form action="{{ route('admin.user.unblock', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="tf-button style-1 w208 bg-green">Unblock User</button>
                                </form>
                            @else
                                <form action="{{ route('admin.user.block', $user->id) }}" method="POST"
                                    id="block-form-detail">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="tf-button style-1 w208 bg-danger"
                                        id="block-btn-detail">Block
                                        User</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#block-btn-detail').on('click', function(e) {
                e.preventDefault();
                var form = $('#block-form-detail');
                swal({
                    title: "Blokir Pengguna?",
                    text: "Pengguna ini tidak akan bisa mengakses website setelah diblokir.",
                    type: "warning",
                    buttons: ["Batal", "Ya, Blokir!"],
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
