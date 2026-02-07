@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Tambah Produk</h3>
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
                        <a href="{{ route('admin.products') }}">
                            <div class="text-tiny">Produk</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Tambah Produk</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.store') }}">
                @csrf
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Nama Produk <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter Nama Produk" name="name" tabindex="0"
                            value="{{ old('name') }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            Nama Produk.</div>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0"
                            value="{{ old('slug') }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            Nama Produk.</div>
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="" name="category_id" required>
                                    <option value="">Choose category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('category_id')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="gap22 cols">
                        <fieldset class="region">
                            <div class="body-title mb-10">Region (Daerah Asal)</div>
                            <div class="select">
                                <select class="" name="region_id">
                                    <option value="">Pilih Region</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}
                                            {{ $region->province }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('region_id')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <fieldset class="farmer">
                            <div class="body-title mb-10">Farmer (Petani)</div>
                            <div class="select">
                                <select class="" name="farmer_id">
                                    <option value="">Pilih Petani</option>
                                    @foreach ($farmers as $farmer)
                                        <option value="{{ $farmer->id }}">{{ $farmer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('farmer_id')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Deskripsi Singkat <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Deskripsi Singkat" tabindex="0"
                            aria-required="true" required="">{{ old('short_description') }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            Nama Produk.</div>
                    </fieldset>
                    @error('short_description')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                        </div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true"
                            required="">{{ old('description') }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            Nama Produk.</div>
                    </fieldset>
                    @error('description')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Status Organik <span class="tf-color-1">*</span></div>
                            <div class="select mb-10">
                                <select name="organic_status" id="organic_status" tabindex="0">
                                    <option value="">Pilih Status</option>
                                    <option value="Organik" {{ old('organic_status') == 'Organik' ? 'selected' : '' }}>
                                        Organik</option>
                                    <option value="Non-Organik"
                                        {{ old('organic_status') == 'Non-Organik' ? 'selected' : '' }}>Non-Organik</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    {{-- Organic Specific Fields --}}
                    <div id="organic-fields" style="display: none;">
                        <fieldset class="name">
                            <div class="body-title mb-10">Periode Panen <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Contoh: Januari - Maret"
                                name="harvest_period" tabindex="0" value="{{ old('harvest_period') }}">
                        </fieldset>

                        <fieldset class="name">
                            <div class="body-title mb-10">Masa Simpan <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Contoh: 7-10 hari" name="shelf_life"
                                tabindex="0" value="{{ old('shelf_life') }}">
                        </fieldset>
                    </div>

                    {{-- Non-Organic Specific Fields --}}
                    <div id="non-organic-fields" style="display: none;">
                        <div class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">Tanggal Produksi <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="date" name="production_date" tabindex="0"
                                    value="{{ old('production_date') }}">
                            </fieldset>
                            <fieldset class="name">
                                <div class="body-title mb-10">Masa Berlaku <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="date" name="expiry_date" tabindex="0"
                                    value="{{ old('expiry_date') }}">
                            </fieldset>
                        </div>

                        <fieldset class="name">
                            <div class="body-title mb-10">Nomor Izin Edar (BPOM/P-IRT) <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Masukkan nomor izin edar"
                                name="bpom_number" tabindex="0" value="{{ old('bpom_number') }}">
                        </fieldset>

                        <fieldset class="name">
                            <div class="body-title mb-10">Komposisi <span class="tf-color-1">*</span></div>
                            <textarea class="mb-10 ht-100" name="composition" placeholder="Masukkan komposisi produk" tabindex="0">{{ old('composition') }}</textarea>
                        </fieldset>
                    </div>

                    <fieldset class="name">
                        <div class="body-title mb-10">Cara Penyimpanan</div>
                        <textarea class="mb-10" name="storage_info" placeholder="Contoh: Simpan di tempat sejuk dan kering" tabindex="0"
                            aria-required="true" rows="3">{{ old('storage_info') }}</textarea>
                    </fieldset>
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Unggah Gambars <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="../../../localhost_8000/images/upload/upload-1.png" class="effect8"
                                    alt=""
                                    onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22400%22 viewBox=%220 0 400 400%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22400%22 height=%22400%22/%3E%3Cpath fill=%22%23999%22 d=%22M120,140 L120,260 L180,200 L240,260 L280,220 L280,140 Z M160,180 C160,168.95 168.95,160 180,160 C191.05,160 200,168.95 200,180 C200,191.05 191.05,200 180,200 C168.95,200 160,191.05 160,180 Z%22/%3E%3Ctext x=%22200%22 y=%22310%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2218%22 fill=%22%23999%22%3EImage preview%3C/text%3E%3C/svg%3E'">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                            <!-- <div class="item">
                                                                                                                                                                                                                                                                                                                                                                                <img src="images/upload/upload-1.png" alt="">
                                                                                                                                                                                                                                                                                                                                                                            </div>-->
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click
                                            to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*"
                                        multiple="">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('images[]')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror


                    {{-- Product Types Section --}}
                    <div class="product-types-section">
                        <div class="body-title">Tipe Produk <span class="tf-color-1">*</span></div>
                        <div class="product-types-grid">
                            @foreach ($productTypes as $type)
                                <div class="type-checkbox">
                                    <input type="checkbox" name="product_types[]" value="{{ $type->id }}"
                                        id="type_{{ $type->id }}"
                                        {{ in_array($type->id, old('product_types', [])) ? 'checked' : '' }}>
                                    <label for="type_{{ $type->id }}" class="type-label">
                                        <span class="type-icon">{!! $type->icon !!}</span>
                                        <span class="type-name">{{ $type->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-tiny">Pilih minimal 1 tipe produk yang sesuai.</div>
                    </div>
                    @error('product_types')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Unit Prices Section --}}
                    <div class="unit-prices-section">
                        <div class="section-header">
                            <div class="body-title">Harga per Satuan <span class="tf-color-1">*</span></div>
                            <button type="button" class="add-unit-btn" id="addUnitPriceBtn">
                                <i class="icon-plus"></i> Tambah Satuan
                            </button>
                        </div>

                        <table class="unit-prices-table" id="unitPricesTable">
                            <thead>
                                <tr>
                                    <th>Satuan</th>
                                    <th>Harga Normal (Rp)</th>
                                    <th>Harga Diskon (Rp)</th>
                                    <th>Min. Order</th>
                                    <th class="col-primary">Primary</th>
                                    <th class="col-actions">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="unitPricesBody">
                                {{-- Rows will be added dynamically via JavaScript --}}
                            </tbody>
                        </table>

                        <div class="help-text">
                            <i class="icon-info-circle"></i>
                            <span>Primary unit akan ditampilkan sebagai harga utama di halaman produk. Minimal 1 satuan
                                harus ditambahkan.</span>
                        </div>
                    </div>
                    @error('unit_prices')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror


                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU" tabindex="0"
                                value="{{ old('SKU') }}" aria-required="true" required="">
                        </fieldset>
                        @error('SKU')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity"
                                tabindex="0" value="{{ old('quantity') }}" aria-required="true" required="">
                        </fieldset>
                        @error('quantity')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stok</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock">InStock</option>
                                    <option value="outofstock">Out of Stock</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('stoct_status')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Unggulan</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('featured')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Tambah Produk</button>
                    </div>
                </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>

    <!-- Loading Overlay -->
    <div id="uploadLoadingOverlay" class="upload-loading-overlay" style="display: none;">
        <div class="loading-content">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <h3 style="margin-top: 20px; color: #fff;">Menyimpan Produk...</h3>
            <p id="uploadStatusText" style="color: rgba(255,255,255,0.8); margin-top: 10px;">
                Mengupload gambar ke cloud storage...
            </p>
        </div>
    </div>

    <style>
        .upload-loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loading-content {
            text-align: center;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .spinner-border {
            width: 4rem;
            height: 4rem;
            border: 0.4em solid rgba(255, 255, 255, 0.3);
            border-right-color: #fff;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
            display: inline-block;
        }

        @keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-content h3 {
            font-size: 24px;
            font-weight: 600;
        }

        .loading-content p {
            font-size: 14px;
            margin: 0;
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Units data from backend
        const units = @json($units);
        let unitRowCounter = 0;

        $(function() {
            // Form submit handler - show loading overlay and clean price inputs
            $('.form-add-product').on('submit', function(e) {
                // Clean price inputs (remove thousand separators)
                $('.price-input').each(function() {
                    const rawValue = getRawPrice($(this).val());
                    $(this).val(rawValue);
                });

                // Show loading overlay
                $('#uploadLoadingOverlay').fadeIn(300);

                // Disable submit button to prevent double submission
                $(this).find('button[type="submit"]').prop('disabled', true).text('Memproses...');

                // Update status text
                setTimeout(function() {
                    $('#uploadStatusText').text('Menyimpan data produk...');
                }, 500);

                setTimeout(function() {
                    $('#uploadStatusText').text('Memproses gambar untuk upload...');
                }, 1500);

                // Form will continue to submit normally
            });

            // Existing image upload handlers
            $("#myFile").on("change", function(e) {
                const photoInp = $("#myFile");
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            $("#gFile").on("change", function(e) {
                const photoInp = $("#gFile");
                const gphotos = this.files;
                $.each(gphotos, function(key, val) {
                    $("#galUpload").prepend(
                        `<div class="item gitems"><img src="${URL.createObjectURL(val)}" /></div>`
                    );
                });
            });

            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

            // ===================================
            // Organic vs Non-Organic Toggling
            // ===================================
            function toggleOrganicFields() {
                const status = $('#organic_status').val();
                if (status === 'Organik') {
                    $('#organic-fields').slideDown();
                    $('#non-organic-fields').slideUp();
                } else if (status === 'Non-Organik') {
                    $('#organic-fields').slideUp();
                    $('#non-organic-fields').slideDown();
                } else {
                    $('#organic-fields').slideUp();
                    $('#non-organic-fields').slideUp();
                }
            }

            $('#organic_status').on('change', toggleOrganicFields);
            toggleOrganicFields(); // Run on load (for old input validation)

            // ===================================
            // Unit Prices Dynamic Table
            // ===================================

            // Add first row on page load
            addUnitPriceRow();

            // Add Unit Price Row Button
            $('#addUnitPriceBtn').on('click', function() {
                addUnitPriceRow();
            });

            // Remove Unit Price Row (delegated event)
            $(document).on('click', '.remove-unit-btn', function() {
                const rowCount = $('#unitPricesBody tr').length;
                if (rowCount > 1) {
                    $(this).closest('tr').remove();
                    updatePrimaryRadios();
                } else {
                    alert('Minimal 1 satuan harus ada!');
                }
            });

            // Primary radio change handler
            $(document).on('change', 'input[name="primary_unit"]', function() {
                const rowIndex = $(this).val();
                updatePrimaryCheckbox(rowIndex);
            });

            // ===================================
            // Price Input Formatting (Thousand Separator)
            // ===================================
            $(document).on('input', '.price-input', function() {
                formatPriceInput($(this));
            });

            // Format existing inputs on load
            $('.price-input').each(function() {
                formatPriceInput($(this));
            });
        });

        // Format price input with thousand separator
        function formatPriceInput(input) {
            let value = input.val();

            // Remove all non-digit characters except dot and comma
            value = value.replace(/[^\d]/g, '');

            // If empty, set to empty string
            if (value === '') {
                input.val('');
                return;
            }

            // Convert to number and format with thousand separator (dot)
            const number = parseInt(value);
            const formatted = number.toLocaleString('id-ID');

            input.val(formatted);
        }

        // Get raw number value from formatted input
        function getRawPrice(formattedValue) {
            return formattedValue.replace(/\./g, '');
        }

        function addUnitPriceRow() {
            const rowIndex = unitRowCounter++;
            const unitsOptions = units.map(unit =>
                `<option value="${unit.id}">${unit.name} (${unit.symbol})</option>`
            ).join('');

            const isFirst = $('#unitPricesBody tr').length === 0;

            const row = `
                <tr>
                    <td>
                        <select name="unit_prices[${rowIndex}][unit_id]" required>
                            <option value="">Pilih Satuan</option>
                            ${unitsOptions}
                        </select>
                    </td>
                    <td>
                        <input type="text" 
                               class="price-input"
                               name="unit_prices[${rowIndex}][regular_price]" 
                               placeholder="0" 
                               required>
                    </td>
                    <td>
                        <input type="text" 
                               class="price-input"
                               name="unit_prices[${rowIndex}][sale_price]" 
                               placeholder="0 (opsional)">
                    </td>
                    <td>
                        <input type="number" 
                               name="unit_prices[${rowIndex}][minimum_order]" 
                               placeholder="1" 
                               value="1"
                               min="0.01"
                               step="0.01" 
                               required>
                    </td>
                    <td class="col-primary">
                        <input type="radio" 
                               name="primary_unit" 
                               value="${rowIndex}"
                               ${isFirst ? 'checked' : ''}>
                        <input type="hidden" 
                               name="unit_prices[${rowIndex}][is_primary]" 
                               value="${isFirst ? '1' : '0'}" 
                               id="primary_${rowIndex}">
                    </td>
                    <td class="col-actions">
                        <button type="button" class="remove-unit-btn" title="Hapus">
                            <i class="icon-trash-2"></i>
                        </button>
                    </td>
                </tr>
            `;

            $('#unitPricesBody').append(row);
        }

        function updatePrimaryCheckbox(rowIndex) {
            // Reset all is_primary to 0
            $('input[name^="unit_prices"][name$="[is_primary]"]').val('0');
            // Set selected one to 1
            $(`#primary_${rowIndex}`).val('1');
        }

        function updatePrimaryRadios() {
            // Ensure at least one is checked
            const checkedCount = $('input[name="primary_unit"]:checked').length;
            if (checkedCount === 0 && $('#unitPricesBody tr').length > 0) {
                // Auto-check first radio
                $('#unitPricesBody tr:first input[name="primary_unit"]').prop('checked', true).trigger('change');
            }
        }

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }
    </script>
@endpush
