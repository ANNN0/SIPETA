@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Slide</h3>
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
                        <a href="{{ route('admin.slides') }}">
                            <div class="text-tiny">Slide</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Slide</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
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
                <form class="form-new-product form-style-1" action="{{ route('admin.slide.update', $slide->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $slide->id }}">
                    <fieldset class="name">
                        <div class="body-title">Subtitle Kecil (Atas) <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Subtitle Kecil" name="subtitle_small"
                            tabindex="0" value="{{ $slide->subtitle_small }}" aria-required="true" required="">
                    </fieldset>
                    @error('subtitle_small')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Judul Utama <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Judul Utama" name="title_main" tabindex="0"
                            value="{{ $slide->title_main }}" aria-required="true" required="">
                    </fieldset>
                    @error('title_main')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Subtitle Besar (Bawah) <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Subtitle Besar" name="subtitle_large"
                            tabindex="0" value="{{ $slide->subtitle_large }}" aria-required="true" required="">
                    </fieldset>
                    @error('subtitle_large')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Link <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Link" name="link" tabindex="0"
                            value="{{ $slide->link }}" aria-required="true" required="">
                    </fieldset>
                    @error('link')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            @if ($slide->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ Str::startsWith($slide->image, 'http') ? $slide->image : asset('uploads/slides') . '/' . $slide->image }}"
                                        class="effect" alt="" />
                                </div>
                            @endif
                            <div class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Max ukuran file: 10MB (jpeg, png, jpg, gif, webp)</small>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <fieldset class="category">
                        <div class="body-title">Status</div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option>Select</option>
                                <option value="1" @if ($slide->status == 1) selected @endif>Active</option>
                                <option value="0" @if ($slide->status == 0) selected @endif>Inactive</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('status')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
            <!-- /new-category -->
        </div>
        <!-- /main-content-wrap -->
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#myFile").on("change", function(e) {
                const photoInp = $("#myFile");
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });
        });
    </script>
@endpush
