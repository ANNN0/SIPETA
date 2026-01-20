@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Region</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.admin') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('admin.regions') }}">
                            <div class="text-tiny">Daerah</div>
                        </a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <div class="text-tiny">Edit Region</div>
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
                <form class="form-new-product form-style-1" action="{{ route('admin.region.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $region->id }}">

                    <fieldset class="name">
                        <div class="body-title">Nama Daerah <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Nama Daerah" name="name"
                            value="{{ old('name', $region->name) }}" required>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title">Region Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Region Slug" name="slug"
                            value="{{ old('slug', $region->slug) }}" required>
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title">Provinsi</div>
                        <input class="flex-grow" type="text" placeholder="e.g., Jawa Barat" name="province"
                            value="{{ old('province', $region->province) }}">
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Description</div>
                        <textarea class="flex-grow" placeholder="Description about this region" name="description">{{ old('description', $region->description) }}</textarea>
                    </fieldset>

                    <fieldset>
                        <div class="body-title">Upload Image (Optional)</div>
                        <div class="upload-image flex-grow">
                            @if ($region->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ Str::startsWith($region->image, 'http') ? $region->image : asset('uploads/regions/' . $region->image) }}"
                                        class="effect8" alt="{{ $region->name }}">
                                </div>
                            @else
                                <div class="item" id="imgpreview" style="display:none">
                                    <img src="#" class="effect8" alt="">
                                </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                    <span class="body-text">Drop your image here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
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
