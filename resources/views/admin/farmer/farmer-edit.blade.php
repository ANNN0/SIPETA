@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Farmer</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.admin') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('admin.farmers') }}">
                            <div class="text-tiny">Petani</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit Farmer</div>
                    </li>
                </ul>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.farmer.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $farmer->id }}">

                    <fieldset class="name">
                        <div class="body-title">Nama Petani <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Farmer/Group name" name="name"
                            value="{{ old('name', $farmer->name) }}" required>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title">Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Farmer Slug" name="slug"
                            value="{{ old('slug', $farmer->slug) }}" required>
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Email</div>
                        <input class="flex-grow" type="email" placeholder="farmer@example.com" name="email"
                            value="{{ old('email', $farmer->email) }}">
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Phone</div>
                        <input class="flex-grow" type="text" placeholder="08123456789" name="phone"
                            value="{{ old('phone', $farmer->phone) }}">
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Location</div>
                        <input class="flex-grow" type="text" placeholder="Desa/Kecamatan" name="location"
                            value="{{ old('location', $farmer->location) }}">
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Daerah</div>
                        <select class="flex-grow" name="region_id">
                            <option value="">Pilih Region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}"
                                    {{ old('region_id', $farmer->region_id) == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }} - {{ $region->province }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>

                    <fieldset class="category">
                        <div class="body-title">Certification</div>
                        <div class="select">
                            <select class="flex-grow" name="certification" tabindex="0">
                                <option value="">Pilih Sertifikasi</option>
                                <option value="Organik"
                                    {{ old('certification', $farmer->certification) == 'Organik' ? 'selected' : '' }}>
                                    Organik</option>
                                <option value="Non-GMO"
                                    {{ old('certification', $farmer->certification) == 'Non-GMO' ? 'selected' : '' }}>
                                    Non-GMO</option>
                                <option value="Fair Trade"
                                    {{ old('certification', $farmer->certification) == 'Fair Trade' ? 'selected' : '' }}>
                                    Fair Trade</option>
                                <option value="GAP"
                                    {{ old('certification', $farmer->certification) == 'GAP' ? 'selected' : '' }}>GAP (Good
                                    Agricultural Practices)</option>
                            </select>
                        </div>
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Description</div>
                        <textarea class="flex-grow" placeholder="Bio/cerita petani..." name="description">{{ old('description', $farmer->description) }}</textarea>
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Status</div>
                        <div class="checkbox-item">
                            <label>
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $farmer->is_active) ? 'checked' : '' }}>
                                <span class="body-text">Active</span>
                            </label>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="body-title">Upload Photo (Optional)</div>
                        <div class="upload-image flex-grow">
                            @if ($farmer->photo)
                                <div class="item" id="imgpreview">
                                    <img src="{{ Str::startsWith($farmer->photo, 'http') ? $farmer->photo : asset('uploads/farmers/' . $farmer->photo) }}"
                                        class="effect8" alt="{{ $farmer->name }}">
                                </div>
                            @else
                                <div class="item" id="imgpreview" style="display:none">
                                    <img src="#" class="effect8" alt="">
                                </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                    <span class="body-text">Drop farmer photo or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="photo" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });
        });
    </script>
@endpush
