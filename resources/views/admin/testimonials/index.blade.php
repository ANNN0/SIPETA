@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Testimonial Management</h3>
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
                        <div class="text-tiny">Testimonials</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search by name, email, or comment..." class=""
                                    name="name" tabindex="2" value="{{ request('name') }}" aria-required="true"
                                    required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="wg-filter">
                        <form>
                            <fieldset class="name">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                </select>
                            </fieldset>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($testimonials as $testimonial)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $testimonial->name }}</td>
                                        <td>{{ $testimonial->email }}</td>
                                        <td>
                                            @if ($testimonial->rating)
                                                <div class="rating-stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <span
                                                            style="color: {{ $i <= $testimonial->rating ? '#1a7a3e' : '#e0e0e0' }}">★</span>
                                                    @endfor
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span data-bs-toggle="tooltip" title="{{ $testimonial->comment }}">
                                                {{ Str::limit($testimonial->comment, 50) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($testimonial->is_approved)
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $testimonial->created_at->format('d M Y') }}</td>
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
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item toggle-approval-item"
                                                            data-name="{{ $testimonial->name }}"
                                                            data-status="{{ $testimonial->is_approved ? 'approved' : 'pending' }}"
                                                            data-action="{{ route('admin.testimonial.toggle', ['id' => $testimonial->id]) }}">
                                                            @if ($testimonial->is_approved)
                                                                <i class="icon-eye-off"></i> Unapprove
                                                            @else
                                                                <i class="icon-check"></i> Approve
                                                            @endif
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item text-danger delete-item"
                                                            data-name="{{ $testimonial->name }}" data-type="Testimonial"
                                                            data-action="{{ route('admin.testimonial.delete', ['id' => $testimonial->id]) }}">
                                                            <i class="icon-trash-2"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No testimonials found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    <x-table-pagination :paginator="$testimonials" />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Approval with Colored Modals
            document.querySelectorAll('.toggle-approval-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const status = this.getAttribute('data-status');
                    const action = this.getAttribute('data-action');
                    const isApproved = status === 'approved';

                    // Different title and color based on action
                    const modalTitle = isApproved ? 'Unapprove Testimonial' : 'Approve Testimonial';
                    const modalMessage = isApproved ?
                        `Are you sure you want to unapprove testimonial from "${name}"? This will hide it from the homepage.` :
                        `Are you sure you want to approve testimonial from "${name}"? This will display it on the homepage.`;
                    const modalColor = isApproved ? 'danger' :
                    'success'; // red for unapprove, green for approve

                    // Use custom colored confirmation modal
                    ModalUtils.showConfirm(
                        modalTitle,
                        modalMessage,
                        modalColor,
                        function() {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = action;
                            form.innerHTML = '@csrf';
                            document.body.appendChild(form);
                            form.submit();
                        }
                    );
                });
            });

            // Delete
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

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
