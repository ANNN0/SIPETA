@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Manajemen Ulasan</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.admin') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Ulasan</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Cari ulasan..." name="name" tabindex="2" required>
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if (Session::has('status'))
                            <p class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>User</th>
                                    <th>Rating</th>
                                    <th>Ulasan</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reviews as $index => $review)
                                    <tr>
                                        <td>{{ ($reviews->currentPage() - 1) * $reviews->perPage() + $index + 1 }}</td>
                                        <td>
                                            @if ($review->product)
                                                <a href="{{ route('shop.product.details', ['product_slug' => $review->product->slug]) }}"
                                                    target="_blank">
                                                    {{ $review->product->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Produk Dihapus</span>
                                            @endif
                                        </td>
                                        <td>{{ $review->reviewer_name ?? 'Anonymous' }}</td>
                                        <td>
                                            <div class="rating-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <i class="icon-star" style="color: #FFD700;"></i>
                                                    @else
                                                        <i class="icon-star" style="color: #ddd;"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </td>
                                        <td style="max-width: 300px;">
                                            <div class="review-text" style="overflow: hidden; text-overflow: ellipsis;">
                                                {{ Str::limit($review->review_text, 100) }}
                                            </div>
                                        </td>
                                        <td>{{ $review->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn-action-dots" type="button" data-bs-toggle="dropdown">
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item text-danger delete-item"
                                                            data-name="Review by {{ $review->reviewer_name ?? 'Anonymous' }}"
                                                            data-type="Review"
                                                            data-action="{{ route('admin.reviews.delete', $review->id) }}">
                                                            <i class="icon-trash-2"></i> Delete
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
                        <x-table-pagination :paginator="$reviews" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Override .pname left alignment for reviews page */
        .pname {
            text-align: center !important;
        }

        .pname div {
            text-align: center !important;
        }
    </style>
@endpush

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
