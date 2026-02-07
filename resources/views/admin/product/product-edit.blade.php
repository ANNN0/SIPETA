@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product</h3>
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
                        <div class="text-tiny">Edit Product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Nama Produk <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter Nama Produk" name="name" tabindex="0"
                            value="{{ $product->name }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            Nama Produk.</div>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0"
                            value="{{ $product->slug }}" aria-required="true" required="">
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
                                <select class="" name="category_id">
                                    <option>Choose category</option>
                                    @foreach ($categories as $category)
                                        <option
                                            value="{{ $category->id }}"{{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
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
                                        <option value="{{ $region->id }}"
                                            {{ $product->region_id == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }} - {{ $region->province }}
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
                                        <option value="{{ $farmer->id }}"
                                            {{ $product->farmer_id == $farmer->id ? 'selected' : '' }}>
                                            {{ $farmer->name }}
                                        </option>
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
                            aria-required="true" required="">{{ $product->short_description }}</textarea>
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
                            required="">{{ $product->description }}</textarea>
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
                                    <option value="Organik" {{ $product->organic_status == 'Organik' ? 'selected' : '' }}>
                                        Organik</option>
                                    <option value="Non-Organik"
                                        {{ $product->organic_status == 'Non-Organik' ? 'selected' : '' }}>Non-Organik
                                    </option>
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    {{-- Organic Specific Fields --}}
                    <div id="organic-fields" style="display: none;">
                        <fieldset class="name">
                            <div class="body-title mb-10">Periode Panen <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Contoh: Januari - Maret"
                                name="harvest_period" tabindex="0" value="{{ $product->harvest_period }}">
                        </fieldset>

                        <fieldset class="name">
                            <div class="body-title mb-10">Masa Simpan <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Contoh: 7-10 hari" name="shelf_life"
                                tabindex="0" value="{{ $product->shelf_life }}">
                        </fieldset>
                    </div>

                    {{-- Non-Organic Specific Fields --}}
                    <div id="non-organic-fields" style="display: none;">
                        <div class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">Tanggal Produksi <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="date" name="production_date" tabindex="0"
                                    value="{{ $product->production_date }}">
                            </fieldset>
                            <fieldset class="name">
                                <div class="body-title mb-10">Masa Berlaku <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="date" name="expiry_date" tabindex="0"
                                    value="{{ $product->expiry_date }}">
                            </fieldset>
                        </div>

                        <fieldset class="name">
                            <div class="body-title mb-10">Nomor Izin Edar (BPOM/P-IRT) <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Masukkan nomor izin edar"
                                name="bpom_number" tabindex="0" value="{{ $product->bpom_number }}">
                        </fieldset>

                        <fieldset class="name">
                            <div class="body-title mb-10">Komposisi <span class="tf-color-1">*</span></div>
                            <textarea class="mb-10 ht-100" name="composition" placeholder="Masukkan komposisi produk" tabindex="0">{{ $product->composition }}</textarea>
                        </fieldset>
                    </div>

                    <fieldset class="name">
                        <div class="body-title mb-10">Cara Penyimpanan</div>
                        <textarea class="mb-10" name="storage_info" placeholder="Contoh: Simpan di tempat sejuk dan kering" tabindex="0"
                            aria-required="true" rows="3">{{ $product->storage_info }}</textarea>
                    </fieldset>
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Unggah Gambars <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            @if ($product->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('uploads/products') . '/' . $product->image }}"
                                        class="effect8" alt="{{ $product->name }}"
                                        onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22400%22 viewBox=%220 0 400 400%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22400%22 height=%22400%22/%3E%3Cpath fill=%22%23999%22 d=%22M120,140 L120,260 L180,200 L240,260 L280,220 L280,140 Z M160,180 C160,168.95 168.95,160 180,160 C191.05,160 200,168.95 200,180 C200,191.05 191.05,200 180,200 C168.95,200 160,191.05 160,180 Z%22/%3E%3Ctext x=%22200%22 y=%22310%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2218%22 fill=%22%23999%22%3EImage not available%3C/text%3E%3C/svg%3E'">
                                </div>
                            @endif
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
                            @if ($product->images)
                                @foreach (explode(',', $product->images) as $img)
                                    <div class="item gitems">
                                        <img src="{{ Str::startsWith(trim($img), 'http') ? trim($img) : asset('uploads/products') . '/' . trim($img) }}"
                                            alt=""
                                            onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22 viewBox=%220 0 200 200%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22200%22 height=%22200%22/%3E%3Cpath fill=%22%23999%22 d=%22M60,70 L60,130 L90,100 L120,130 L140,110 L140,70 Z M80,90 C80,84.48 84.48,80 90,80 C95.52,80 100,84.48 100,90 C100,95.52 95.52,100 90,100 C84.48,100 80,95.52 80,90 Z%22/%3E%3C/svg%3E'">
                                    </div>
                                @endforeach
                            @endif
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
                                        {{ $product->productTypes->contains($type->id) ? 'checked' : '' }}>
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
                                {{-- Populated via JavaScript on page load --}}
                            </tbody>
                        </table>

                        <div class="help-text">
                            <i class="icon-info-circle"></i>
                            <span>Primary unit akan ditampilkan sebagai harga utama di halaman produk.</span>
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
                                value="{{ $product->SKU }}" aria-required="true" required="">
                        </fieldset>
                        @error('SKU')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity"
                                tabindex="0" value="{{ $product->quantity }}" aria-required="true" required="">
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
                                    <option value="instock" {{ $product->stock_status == 'instock' ? 'selected' : '' }}>
                                        InStock</option>
                                    <option value="outofstock"
                                        {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>
                                        Out of Stock</option>
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
                                    <option value="0" {{ $product->featured == '0' ? 'selected' : '' }}>No
                                    </option>
                                    <option value="1" {{ $product->featured == '1' ? 'selected' : '' }}>Yes
                                    </option>
                                </select>
                            </div>
                        </fieldset>
                        @error('featured')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Perbarui Produk</button>
                    </div>
                </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
@endsection

@push('scripts')
    <script>
        const units = @json($units);
        const existingUnitPrices = @json($product->unitPrices);
        let unitRowCounter = 0;

        $(function() {
            // Form submit handler - clean price inputs
            $('.form-add-product').on('submit', function(e) {
                // Clean price inputs (remove thousand separators)
                $('.price-input').each(function() {
                    const rawValue = getRawPrice($(this).val());
                    $(this).val(rawValue);
                });
            });

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
            toggleOrganicFields(); // Run on load

            // ===================================
            // Unit Prices - Pre-populate existing data
            // ===================================
            if (existingUnitPrices && existingUnitPrices.length > 0) {
                existingUnitPrices.forEach(unitPrice => {
                    addUnitPriceRow(unitPrice);
                });
            } else {
                // Add empty row if no existing prices
                addUnitPriceRow();
            }

            $('#addUnitPriceBtn').on('click', function() {
                addUnitPriceRow();
            });

            $(document).on('click', '.remove-unit-btn', function() {
                const rowCount = $('#unitPricesBody tr').length;
                if (rowCount > 1) {
                    $(this).closest('tr').remove();
                    updatePrimaryRadios();
                } else {
                    alert('Minimal 1 satuan harus ada!');
                }
            });

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
            setTimeout(function() {
                $('.price-input').each(function() {
                    formatPriceInput($(this));
                });
            }, 100);
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

        function addUnitPriceRow(existingData = null) {
            const rowIndex = unitRowCounter++;
            const unitsOptions = units.map(unit => {
                const selected = existingData && existingData.unit_id == unit.id ? 'selected' : '';
                return `<option value="${unit.id}" ${selected}>${unit.name} (${unit.symbol})</option>`;
            }).join('');

            const isFirst = $('#unitPricesBody tr').length === 0;
            const isPrimary = existingData ? existingData.is_primary : isFirst;

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
                               value="${existingData ? existingData.regular_price : ''}"
                               required>
                    </td>
                    <td>
                        <input type="text" 
                               class="price-input"
                               name="unit_prices[${rowIndex}][sale_price]" 
                               placeholder="0 (opsional)" 
                               value="${existingData && existingData.sale_price ? existingData.sale_price : ''}">
                    </td>
                    <td>
                        <input type="number" 
                               name="unit_prices[${rowIndex}][minimum_order]" 
                               placeholder="1" 
                               value="${existingData ? existingData.minimum_order : 1}"
                               min="0.01"
                               step="0.01" 
                               required>
                    </td>
                    <td class="col-primary">
                        <input type="radio" 
                               name="primary_unit" 
                               value="${rowIndex}"
                               ${isPrimary ? 'checked' : ''}>
                        <input type="hidden" 
                               name="unit_prices[${rowIndex}][is_primary]" 
                               value="${isPrimary ? '1' : '0'}" 
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
            $('input[name^="unit_prices"][name$="[is_primary]"]').val('0');
            $(`#primary_${rowIndex}`).val('1');
        }

        function updatePrimaryRadios() {
            const checkedCount = $('input[name="primary_unit"]:checked').length;
            if (checkedCount === 0 && $('#unitPricesBody tr').length > 0) {
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
