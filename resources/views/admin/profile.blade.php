@extends('layouts.admin')

@section('content')
    <style>
        .text-danger {
            font-size: initial;
            line-height: 36px;
        }

        .alert-danger {
            font-size: initial;
        }

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .profile-card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .profile-avatar-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            max-width: 100px;
            max-height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #2377FC;
        }

        .profile-info h3 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .profile-info p {
            margin: 0;
            color: #777;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Admin Profile</h3>
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
                        <div class="text-tiny">Profile</div>
                    </li>
                </ul>
            </div>

            <div class="profile-container">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar-wrapper">
                            @if ($user->image)
                                <img src="{{ $user->image }}" alt="{{ $user->name }}" class="profile-avatar">
                            @else
                                <div
                                    class="profile-avatar d-flex align-items-center justify-content-center bg-primary text-white fs-1 fw-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="profile-info">
                            <h3>{{ $user->name }}</h3>
                            <p>{{ $user->email }}</p>
                            <span class="badge bg-primary mt-2">Administrator</span>
                        </div>
                    </div>

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="form-add-product">
                        @csrf
                        @method('PUT')

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="wg-box">
                            <fieldset class="name">
                                <div class="body-title mb-10">Name <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" placeholder="Enter your name" name="name"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="alert alert-danger text-center">{{ $message }}</span>
                                @enderror
                            </fieldset>

                            <fieldset class="email">
                                <div class="body-title mb-10">Email Address <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="email" placeholder="Enter email address" name="email"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="alert alert-danger text-center">{{ $message }}</span>
                                @enderror
                            </fieldset>

                            <fieldset class="password">
                                <div class="body-title mb-10">New Password (Leave blank to keep current)</div>
                                <input class="mb-10" type="password" placeholder="Enter new password" name="password">
                                @error('password')
                                    <span class="alert alert-danger text-center">{{ $message }}</span>
                                @enderror
                            </fieldset>

                            <fieldset class="password_confirmation">
                                <div class="body-title mb-10">Confirm New Password</div>
                                <input class="mb-10" type="password" placeholder="Confirm new password"
                                    name="password_confirmation">
                            </fieldset>

                            <fieldset class="image">
                                <div class="body-title mb-10">Profile Image</div>
                                <div class="upload-image flex-grow">
                                    <div class="item" id="imgpreview"
                                        style="{{ $user->image ? 'display:block' : 'display:none' }}">
                                        @if ($user->image)
                                            <img src="{{ $user->image }}" class="effect8" alt="Preview"
                                                style="max-width: 200px; max-height: 200px; object-fit: contain;">
                                        @else
                                            <img src="#" class="effect8" alt="Preview"
                                                style="max-width: 200px; max-height: 200px; object-fit: contain;">
                                        @endif
                                    </div>
                                    <div id="upload-file" class="item up-load">
                                        <label class="uploadfile" for="myFile">
                                            <span class="icon">
                                                <i class="icon-upload-cloud"></i>
                                            </span>
                                            <span class="body-text">Drop your images here or select <span
                                                    class="tf-color">click to browse</span></span>
                                            <input type="file" id="myFile" name="image" accept="image/*">
                                        </label>
                                    </div>
                                </div>
                                @error('image')
                                    <span class="alert alert-danger text-center">{{ $message }}</span>
                                @enderror
                            </fieldset>

                            <div class="bot">
                                <button class="tf-button w208" type="submit">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
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
