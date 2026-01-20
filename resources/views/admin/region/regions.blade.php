@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Daerah</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.admin') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Daerah</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Cari daerah..." name="name" tabindex="2"
                                    value="{{ request('name') }}" required>
                            </fieldset>
                            <div class="button-submit">
                                <button type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.region.add') }}">
                        <i class="icon-plus"></i>Add new
                    </a>
                </div>
                <div class="table-responsive">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Provinsi</th>
                                <th>Products</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($regions as $region)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($region->image)
                                            <div class="region-item-wrapper justify-content-center">
                                                <img src="{{ Str::startsWith($region->image, 'http') ? $region->image : asset('uploads/regions/' . $region->image) }}"
                                                    alt="{{ $region->name }}" class="region-thumbnail">
                                                <div class="region-info">
                                                    <div class="region-name">{{ $region->name }}</div>
                                                    <div class="region-slug">{{ $region->slug }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="region-info">
                                                <div class="region-name">{{ $region->name }}</div>
                                                <div class="region-slug">{{ $region->slug }}</div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $region->province ?? '-' }}</td>
                                    <td><a href="#">{{ $region->products_count }}</a></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn-action-dots" type="button" data-bs-toggle="dropdown">
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                                <span class="dot"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.region.edit', ['id' => $region->id]) }}">Edit</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-item text-danger delete-item"
                                                        data-name="{{ $region->name }}" data-type="Region"
                                                        data-action="{{ route('admin.region.delete', ['id' => $region->id]) }}">
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
                    <x-table-pagination :paginator="$regions" />
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
