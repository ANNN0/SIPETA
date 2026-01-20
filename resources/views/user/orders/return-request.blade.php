@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="return-request-section container">
            <div class="return-page">
                <!-- Back Button & Page Title -->
                <div class="return-header">
                    <a href="{{ route('user.orders') }}" class="btn-back btn-sm">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                    <h1>Ajukan Pengembalian</h1>
                    <p class="subtitle">Order ID: {{ $order_id_formatted }}</p>
                </div>

                <form action="{{ route('user.order.return.submit', $order->id) }}" method="POST" class="return-form"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="return-layout">
                        <!-- LEFT COLUMN (Main Content) -->
                        <div class="return-main">
                            <!-- Product Card -->
                            <div class="return-card product-card-section">
                                @foreach ($orderItems as $item)
                                    <div class="product-item-enhanced">
                                        <div class="product-image-box">
                                            @if (str_starts_with($item->product->image, 'http'))
                                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}">
                                            @else
                                                <img src="{{ asset('uploads/products/thumbnails/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}">
                                            @endif
                                        </div>
                                        <div class="product-details">
                                            <h4 class="product-name-enhanced">{{ $item->product->name }}</h4>
                                            <p class="product-meta-enhanced">Qty: {{ $item->quantity }}</p>
                                            <p class="product-price-enhanced">Harga: Rp
                                                {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Alasan Pengembalian (Custom Dropdown) -->
                            <div class="return-card">
                                <label class="form-label">Alasan Pengembalian</label>
                                <div class="custom-dropdown" id="customDropdown">
                                    <input type="hidden" name="reason" id="returnReason" required>
                                    <div class="dropdown-selected" id="dropdownSelected">
                                        <span class="placeholder">Pilih Alasan</span>
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                    <div class="dropdown-options" id="dropdownOptions">
                                        <div class="dropdown-option" data-value="damaged">
                                            <i class="fa fa-exclamation-circle"></i>
                                            <span>Produk Rusak/Cacat</span>
                                        </div>
                                        <div class="dropdown-option" data-value="not_as_described">
                                            <i class="fa fa-exclamation-triangle"></i>
                                            <span>Produk Tidak Sesuai Deskripsi</span>
                                        </div>
                                        <div class="dropdown-option" data-value="wrong_item">
                                            <i class="fa fa-random"></i>
                                            <span>Salah Kirim Produk</span>
                                        </div>
                                        <div class="dropdown-option" data-value="changed_mind">
                                            <i class="fa fa-undo"></i>
                                            <span>Berubah Pikiran</span>
                                        </div>
                                        <div class="dropdown-option" data-value="other">
                                            <i class="fa fa-ellipsis-h"></i>
                                            <span>Lainnya</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Bukti (Foto & Video) -->
                            <div class="return-card">
                                <label class="form-label">Unggah Foto/Video Bukti (Maks. 6 File)</label>
                                <p class="upload-hint-text">Format: JPG, PNG, MP4, MOV (Maks. 10MB per file)</p>
                                <div class="upload-area-grid" id="uploadArea">
                                    <input type="file" name="photos[]" id="photoInput" multiple accept="image/*,video/*"
                                        hidden>
                                    <div class="upload-grid" id="uploadGrid">
                                        <div class="upload-slot upload-add"
                                            onclick="document.getElementById('photoInput').click()">
                                            <i class="fa fa-plus"></i>
                                            <span>Tambah File</span>
                                        </div>
                                        <!-- Preview items will be added here dynamically -->
                                    </div>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="return-card">
                                <label class="form-label">Detail Masalah</label>
                                <div class="form-group">
                                    <textarea name="description" id="description" rows="4" class="form-textarea-enhanced" placeholder="Detail Masalah"
                                        maxlength="500" required></textarea>
                                    <div class="char-counter">
                                        <span id="charCount">0</span>/500 karakter
                                    </div>
                                </div>
                            </div>

                            <!-- Kontak Pengguna -->
                            <div class="return-card">
                                <label class="form-label"><i class="fa fa-user"></i> Kontak Pengguna</label>
                                <p class="card-hint">Informasi kontak untuk komunikasi terkait pengembalian</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-sublabel">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="contact_name" class="form-input-enhanced"
                                                value="{{ Auth::user()->name }}" placeholder="Nama Lengkap" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-sublabel">Nomor Telepon <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="contact_phone" class="form-input-enhanced"
                                                value="{{ Auth::user()->mobile ?? '' }}" placeholder="08xxxxxxxxxx"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alamat Pengirim -->
                            <div class="return-card">
                                <label class="form-label"><i class="fa fa-map-marker"></i> Alamat Pengirim</label>
                                <p class="card-hint">Alamat untuk pengiriman barang yang akan dikembalikan</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-sublabel">Alamat Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="sender_address" rows="2" class="form-textarea-enhanced"
                                                placeholder="No. Rumah, Nama Jalan, RT/RW" required>{{ $order->address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-sublabel">Kota/Kabupaten <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="sender_city" class="form-input-enhanced"
                                                value="{{ $order->city ?? '' }}" placeholder="Kota/Kabupaten" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-sublabel">Provinsi <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="sender_state" class="form-input-enhanced"
                                                value="{{ $order->state ?? '' }}" placeholder="Provinsi" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="form-sublabel">Kode Pos <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="sender_zip" class="form-input-enhanced"
                                                value="{{ $order->zip ?? '' }}" placeholder="Kode Pos" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-submit-enhanced">
                                <i class="fa fa-paper-plane"></i> Kirim Permintaan
                            </button>
                        </div>

                        <!-- RIGHT COLUMN (Sidebar Summary) -->
                        <div class="return-sidebar">
                            <!-- Ringkasan Pengembalian -->
                            <div class="summary-card">
                                <h3 class="summary-title">Ringkasan Pengembalian</h3>

                                <div class="summary-section">
                                    <h4 class="summary-subtitle">Detail Pesanan</h4>
                                    <div class="summary-row">
                                        <span class="summary-label">Order ID</span>
                                        <span class="summary-value">{{ $order_id_formatted }}</span>
                                    </div>
                                    <div class="summary-row">
                                        <span class="summary-label">Tanggal</span>
                                        <span class="summary-value">{{ $order->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="summary-row">
                                        <span class="summary-label">Total Amount</span>
                                        <span class="summary-value total">Rp
                                            {{ number_format($order->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="summary-section">
                                    <h4 class="summary-subtitle">Pilih Solusi</h4>
                                    <label class="solution-card">
                                        <input type="radio" name="solution" value="refund" checked>
                                        <div class="solution-content">
                                            <div class="solution-checkbox">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div class="solution-icon">
                                                <i class="fa fa-money"></i>
                                            </div>
                                            <div class="solution-text">
                                                <span class="solution-name">Pengembalian Dana (Refund)</span>
                                                <span class="solution-desc">Dana akan dikembalikan ke rekening pembayaran
                                                    awal.</span>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="solution-card">
                                        <input type="radio" name="solution" value="exchange">
                                        <div class="solution-content">
                                            <div class="solution-checkbox">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div class="solution-icon">
                                                <i class="fa fa-exchange"></i>
                                            </div>
                                            <div class="solution-text">
                                                <span class="solution-name">Penukaran Barang (Exchange)</span>
                                                <span class="solution-desc">Kami akan mengirimkan produk pengganti.</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Tips Info Box -->
                            <div class="tips-box">
                                <div class="tips-icon">
                                    <i class="fa fa-info-circle"></i>
                                </div>
                                <div class="tips-content">
                                    <h5>Tips Kebijakan Pengembalian:</h5>
                                    <p>Pastikan produk dalam kondisi asli dan kemasan lengkap. Proses pengembalian berlaku
                                        dalam waktu 3-5 hari kerja.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <div class="mb-5 pb-xl-5"></div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Custom Dropdown
            const customDropdown = document.getElementById('customDropdown');
            const dropdownSelected = document.getElementById('dropdownSelected');
            const dropdownOptions = document.getElementById('dropdownOptions');
            const returnReason = document.getElementById('returnReason');

            dropdownSelected.addEventListener('click', function() {
                customDropdown.classList.toggle('active');
            });

            document.querySelectorAll('.dropdown-option').forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.dataset.value;
                    const text = this.querySelector('span').textContent;
                    const icon = this.querySelector('i').className;

                    returnReason.value = value;
                    dropdownSelected.innerHTML = `
                        <span><i class="${icon}"></i> ${text}</span>
                        <i class="fa fa-chevron-down"></i>
                    `;
                    dropdownSelected.classList.add('selected');
                    customDropdown.classList.remove('active');
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!customDropdown.contains(e.target)) {
                    customDropdown.classList.remove('active');
                }
            });

            // File Upload & Preview
            const photoInput = document.getElementById('photoInput');
            const uploadGrid = document.getElementById('uploadGrid');
            const description = document.getElementById('description');
            const charCount = document.getElementById('charCount');
            let fileCount = 0;
            const maxFiles = 6;

            // Character counter
            description.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });

            // Handle file selection
            photoInput.addEventListener('change', function() {
                handleFiles(this.files);
            });

            // Drag and drop
            const uploadArea = document.getElementById('uploadArea');
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const files = e.dataTransfer.files;
                handleFiles(files);
            });

            function handleFiles(files) {
                if (fileCount >= maxFiles) {
                    Toast.warning('Maksimal 6 file yang dapat diunggah');
                    return;
                }

                const filesToAdd = Math.min(files.length, maxFiles - fileCount);

                for (let i = 0; i < filesToAdd; i++) {
                    const file = files[i];

                    // Check file size (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        Toast.warning(`File ${file.name} terlalu besar. Maksimal 10MB per file.`);
                        continue;
                    }

                    // Check if it's image or video
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            addPreview(e.target.result, 'image');
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type.startsWith('video/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            addPreview(e.target.result, 'video');
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }

            function addPreview(src, type) {
                const slot = document.createElement('div');
                slot.className = 'upload-slot upload-preview';

                if (type === 'image') {
                    slot.innerHTML = `
                        <img src="${src}" alt="Preview">
                        <button type="button" class="remove-photo" onclick="removeFile(this)">
                            <i class="fa fa-times"></i>
                        </button>
                    `;
                } else if (type === 'video') {
                    slot.innerHTML = `
                        <video src="${src}"></video>
                        <div class="video-overlay"><i class="fa fa-play-circle"></i></div>
                        <button type="button" class="remove-photo" onclick="removeFile(this)">
                            <i class="fa fa-times"></i>
                        </button>
                    `;
                }

                // Insert before the "add" button
                const addButton = uploadGrid.querySelector('.upload-add');
                uploadGrid.insertBefore(slot, addButton);
                fileCount++;

                // Hide add button if max reached
                if (fileCount >= maxFiles) {
                    addButton.style.display = 'none';
                }
            }

            // Global function for removing files
            window.removeFile = function(btn) {
                btn.closest('.upload-slot').remove();
                fileCount--;

                // Show add button again
                const addButton = uploadGrid.querySelector('.upload-add');
                if (addButton) {
                    addButton.style.display = 'flex';
                }
            };
        });
    </script>
@endpush
