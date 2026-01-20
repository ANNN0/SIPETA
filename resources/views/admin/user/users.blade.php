@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Daftar Pengguna</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.admin') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">User</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="user-search-form" method="GET" action="{{ route('admin.users') }}">
                            <fieldset class="name">
                                <input type="text" placeholder="Cari user (Nama, Email, Telepon)..." name="name"
                                    tabindex="2" value="{{ request('name') }}">
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div>
                    @if (Session::has('status'))
                        <p class="alert alert-success mt-3">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Kontak</th>
                                <th>Bergabung</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($user->image)
                                                <img src="@cloudinary($user->image, 80, 80, 'fill')" alt="{{ $user->name }}"
                                                    style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-right: 12px;">
                                            @else
                                                <div
                                                    style="width: 40px; height: 40px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-weight: bold; color: #666;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-medium">{{ $user->name }}</div>
                                                <div class="text-muted small">ID: #{{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $user->email }}</div>
                                        <div class="text-tiny mt-1">{{ $user->mobile ?? '-' }}</div>
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if ($user->is_blocked)
                                            <span class="badge bg-danger">Blocked</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
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
                                                        href="{{ route('admin.user.details', $user->id) }}">
                                                        Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    @if ($user->is_blocked)
                                                        <form action="{{ route('admin.user.unblock', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="dropdown-item text-success">Unblock</button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.user.block', $user->id) }}"
                                                            method="POST" class="block-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button"
                                                                class="dropdown-item text-danger block-btn">Block</button>
                                                        </form>
                                                    @endif
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
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('.block-btn').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Blokir Pengguna?",
                    text: "Pengguna ini tidak akan bisa mengakses website setelah diblokir.",
                    type: "warning",
                    buttons: ["Batal", "Blokir"],
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
