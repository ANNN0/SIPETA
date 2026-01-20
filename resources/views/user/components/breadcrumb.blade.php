{{-- User Breadcrumb Component --}}
<div class="user-breadcrumb">
    <a href="{{ route('home.index') }}">Beranda</a>
    <span class="separator">/</span>
    <span class="current">{{ $currentPage }}</span>
</div>
