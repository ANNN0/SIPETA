@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Slide Split</h3>
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
                        <a href="{{ route('admin.slide.splits') }}">
                            <div class="text-tiny">Slide Split</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Slide Split</div>
                    </li>
                </ul>
            </div>
            <!-- edit-slide-split -->
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
                <form class="form-new-product form-style-1" action="{{ route('admin.slide.split.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $slideSplit->id }}" />

                    <fieldset class="name">
                        <div class="body-title">Title <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Title" name="title" tabindex="0"
                            value="{{ old('title', $slideSplit->title) }}" aria-required="true" required="">
                    </fieldset>
                    @error('title')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title">Subtitle</div>
                        <textarea class="flex-grow" placeholder="Subtitle (optional)" name="subtitle" tabindex="0" rows="3">{{ old('subtitle', $slideSplit->subtitle) }}</textarea>
                    </fieldset>
                    @error('subtitle')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title">Background Color (Text Section) <span class="tf-color-1">*</span></div>
                        <div class="d-flex gap-3 align-items-center">
                            <input class="flex-grow" type="color" name="background_color"
                                value="{{ old('background_color', $slideSplit->background_color) }}" required>
                            <input class="form-control" type="text" name="background_color_hex" id="colorHex"
                                value="{{ old('background_color', $slideSplit->background_color) }}"
                                pattern="^#[a-fA-F0-9]{6}$" placeholder="#e8f5e9" style="max-width: 120px;">
                        </div>
                        <small class="text-muted">Preset warna soft:
                            <a href="#" class="color-preset" data-color="#e8f5e9">🟢 Soft Green</a> |
                            <a href="#" class="color-preset" data-color="#f5e6e0">🟠 Soft Peach</a> |
                            <a href="#" class="color-preset" data-color="#e3f2fd">🔵 Soft Blue</a> |
                            <a href="#" class="color-preset" data-color="#fce4ec">🌸 Soft Pink</a>
                        </small>
                    </fieldset>
                    @error('background_color')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset>
                        <div class="body-title">Background Image</div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview">
                                <img src="{{ Str::startsWith($slideSplit->background_image, 'http') ? $slideSplit->background_image : asset('uploads/slide-splits/' . $slideSplit->background_image) }}"
                                    class="effect" alt="{{ $slideSplit->title }}" />
                            </div>
                            <div class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your image here or select <span class="tf-color">click to
                                            browse</span></span>
                                    <input type="file" id="myFile" name="background_image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Leave empty to keep current image | Max file size: 10MB (jpeg, png, jpg,
                            gif, webp) | Recommended: 3840x2160 (4K)</small>
                    </fieldset>
                    @error('background_image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="category">
                        <div class="body-title">Status</div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option value="1" @if (old('status', $slideSplit->status) == 1) selected @endif>Active</option>
                                <option value="0" @if (old('status', $slideSplit->status) == 0) selected @endif>Inactive</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('status')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Update</button>
                    </div>
                </form>
            </div>
            <!-- /edit-slide-split -->
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

            // Sync color picker with hex input
            $('input[name="background_color"]').on('input', function() {
                $('#colorHex').val($(this).val());
            });

            $('#colorHex').on('input', function() {
                let hex = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
                    $('input[name="background_color"]').val(hex);
                }
            });

            // Color presets
            $('.color-preset').on('click', function(e) {
                e.preventDefault();
                let color = $(this).data('color');
                $('input[name="background_color"]').val(color);
                $('#colorHex').val(color);
            });
        });
    </script>
@endpush
