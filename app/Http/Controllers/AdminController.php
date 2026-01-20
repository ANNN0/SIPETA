<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Slide;
use App\Models\SlideSplit;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Search;
use App\Models\ProductReview;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(10);
        $dashboardDatas = DB::select("Select sum(total) As TotalAmount,
                                    sum(if(status='ordered',total,0)) As TotalOrderedAmount,
                                    sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
                                    sum(if(status='canceled',total,0)) As TotalCanceledAmount,
                                    Count(*) As Total,
                                    sum(if(status='ordered',1,0)) As TotalOrdered,
                                    sum(if(status='delivered',1,0)) As TotalDelivered,
                                    sum(if(status='canceled',1,0)) As TotalCanceled
                                    From Orders");

        $monthlyDatas = DB::select("SELECT M.id As MonthNo, M.name As MonthName,
        IFNULL(D.TotalAmount, 0) As TotalAmount,
        IFNULL(D.TotalOrderedAmount, 0) As TotalOrderedAmount,
        IFNULL(D.TotalDeliveredAmount, 0) As TotalDeliveredAmount,
        IFNULL(D.TotalCanceledAmount, 0) As TotalCanceledAmount FROM month_names M
        LEFT JOIN (Select DATE_FORMAT(created_at, '%b') As MonthName,
        MONTH(created_at) As MonthNo,
        sum(total) As TotalAmount,
        sum(if(status='ordered',total,0)) As TotalOrderedAmount,
        sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
        sum(if(status='canceled',total,0)) As TotalCanceledAmount
        From Orders WHERE YEAR(created_at)=YEAR(NOW()) GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
        Order By MONTH(created_at)) D On D.MonthNo=M.id;
        ");

        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());

        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

        return view('admin.admin', compact('orders', 'dashboardDatas', 'monthlyDatas', 'AmountM', 'OrderedAmountM', 'DeliveredAmountM', 'CanceledAmountM', 'TotalAmount', 'TotalOrderedAmount', 'TotalDeliveredAmount', 'TotalCanceledAmount'));
    }

    /**
     * Export dashboard data to PDF
     */
    public function exportDashboardPdf()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get();
        $dashboardDatas = DB::select("Select sum(total) As TotalAmount,
                                    sum(if(status='ordered',total,0)) As TotalOrderedAmount,
                                    sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
                                    sum(if(status='canceled',total,0)) As TotalCanceledAmount,
                                    Count(*) As Total,
                                    sum(if(status='ordered',1,0)) As TotalOrdered,
                                    sum(if(status='delivered',1,0)) As TotalDelivered,
                                    sum(if(status='canceled',1,0)) As TotalCanceled
                                    From Orders");

        $monthlyDatas = DB::select("SELECT M.id As MonthNo, M.name As MonthName,
        IFNULL(D.TotalAmount, 0) As TotalAmount,
        IFNULL(D.TotalOrderedAmount, 0) As TotalOrderedAmount,
        IFNULL(D.TotalDeliveredAmount, 0) As TotalDeliveredAmount,
        IFNULL(D.TotalCanceledAmount, 0) As TotalCanceledAmount FROM month_names M
        LEFT JOIN (Select DATE_FORMAT(created_at, '%b') As MonthName,
        MONTH(created_at) As MonthNo,
        sum(total) As TotalAmount,
        sum(if(status='ordered',total,0)) As TotalOrderedAmount,
        sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
        sum(if(status='canceled',total,0)) As TotalCanceledAmount
        From Orders WHERE YEAR(created_at)=YEAR(NOW()) GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
        Order By MONTH(created_at)) D On D.MonthNo=M.id;
        ");

        $generatedAt = Carbon::now()->format('d F Y, H:i');

        $pdf = Pdf::loadView('admin.exports.dashboard-pdf', compact(
            'orders',
            'dashboardDatas',
            'monthlyDatas',
            'generatedAt'
        ));

        $pdf->setPaper('A4', 'portrait');

        $filename = 'laporan-dashboard-SIPETA-' . Carbon::now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    // ========================================
    // REGIONS CRUD
    // ========================================

    // ========================================
    // REGIONS CRUD
    // ========================================

    public function regions(Request $request)
    {
        $query = \App\Models\Region::withCount('products')->orderBy('id', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('province', 'LIKE', "%{$searchTerm}%");
            });
        }

        $regions = $query->paginate(10);
        return view('admin.region.regions', compact('regions'));
    }

    public function region_add()
    {
        return view('admin.region.region-add');
    }

    public function region_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:regions,slug',
            'province' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:10048',
        ]);

        $region = new \App\Models\Region();
        $region->name = $request->name;
        $region->slug = Str::slug($request->slug);
        $region->province = $request->province;
        $region->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $url = $this->GenerateRegionThumbnailsImage($image, $file_name);
            $region->image = $url;
        }

        $region->save();
        return redirect()->route('admin.regions')->with('status', 'Region has been added successfully.');
    }

    public function region_edit($id)
    {
        $region = \App\Models\Region::find($id);
        return view('admin.region.region-edit', compact('region'));
    }

    public function region_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:regions,slug,' . $request->id,
            'province' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:10048',
        ]);

        $region = \App\Models\Region::find($request->id);
        $region->name = $request->name;
        $region->slug = Str::slug($request->slug);
        $region->province = $request->province;
        $region->description = $request->description;

        if ($request->hasFile('image')) {
            // No need to delete local file if we are moving to Cloudinary specific logic, 
            // but if we want to delete old Cloudinary image, we'd need its Public ID. 
            // For now, let's just upload the new one.
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $url = $this->GenerateRegionThumbnailsImage($image, $file_name);
            $region->image = $url;
        }

        $region->save();
        return redirect()->route('admin.regions')->with('status', 'Region has been updated successfully.');
    }

    public function GenerateRegionThumbnailsImage($image, $imageName)
    {
        $publicId = pathinfo($imageName, PATHINFO_FILENAME);
        return Cloudinary::uploadApi()->upload($image->getRealPath(), [
            'folder' => 'regions',
            'public_id' => $publicId
        ])['secure_url'];
    }

    public function region_delete($id)
    {
        $region = \App\Models\Region::find($id);
        if (File::exists(public_path('uploads/regions') . '/' . $region->image)) {
            File::delete(public_path('uploads/regions') . '/' . $region->image);
        }
        $region->delete();
        return redirect()->route('admin.regions')->with('status', 'Region has been deleted successfully.');
    }

    // ========================================
    // FARMERS CRUD
    // ========================================

    public function farmers(Request $request)
    {
        $query = \App\Models\Farmer::with('region')->withCount('products')->orderBy('id', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('region', function ($regionQuery) use ($searchTerm) {
                        $regionQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        $farmers = $query->paginate(10);
        return view('admin.farmer.farmers', compact('farmers'));
    }

    public function farmer_add()
    {
        $regions = \App\Models\Region::orderBy('name')->get();
        return view('admin.farmer.farmer-add', compact('regions'));
    }

    public function farmer_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:farmers,slug',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable',
            'region_id' => 'nullable|exists:regions,id',
            'description' => 'nullable|string',
            'certification' => 'nullable|string',
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:10048',
        ]);

        $farmer = new \App\Models\Farmer();
        $farmer->name = $request->name;
        $farmer->slug = Str::slug($request->slug);
        $farmer->email = $request->email;
        $farmer->phone = $request->phone;
        $farmer->location = $request->location;
        $farmer->region_id = $request->region_id;
        $farmer->description = $request->description;
        $farmer->certification = $request->certification;
        $farmer->is_active = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $url = $this->GenerateFarmerPhotoImage($image, $file_name);
            $farmer->photo = $url;
        }

        $farmer->save();
        return redirect()->route('admin.farmers')->with('status', 'Farmer has been added successfully.');
    }

    public function farmer_edit($id)
    {
        $farmer = \App\Models\Farmer::find($id);
        $regions = \App\Models\Region::orderBy('name')->get();
        return view('admin.farmer.farmer-edit', compact('farmer', 'regions'));
    }

    public function farmer_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:farmers,slug,' . $request->id,
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable',
            'region_id' => 'nullable|exists:regions,id',
            'description' => 'nullable|string',
            'certification' => 'nullable|string',
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:10048',
        ]);

        $farmer = \App\Models\Farmer::find($request->id);
        $farmer->name = $request->name;
        $farmer->slug = Str::slug($request->slug);
        $farmer->email = $request->email;
        $farmer->phone = $request->phone;
        $farmer->location = $request->location;
        $farmer->region_id = $request->region_id;
        $farmer->description = $request->description;
        $farmer->certification = $request->certification;
        $farmer->is_active = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $url = $this->GenerateFarmerPhotoImage($image, $file_name);
            $farmer->photo = $url;
        }

        $farmer->save();
        return redirect()->route('admin.farmers')->with('status', 'Farmer has been updated successfully.');
    }

    public function GenerateFarmerPhotoImage($image, $imageName)
    {
        $publicId = pathinfo($imageName, PATHINFO_FILENAME);
        return Cloudinary::uploadApi()->upload($image->getRealPath(), [
            'folder' => 'farmers',
            'public_id' => $publicId
        ])['secure_url'];
    }

    public function farmer_delete($id)
    {
        $farmer = \App\Models\Farmer::find($id);
        if (File::exists(public_path('uploads/farmers') . '/' . $farmer->photo)) {
            File::delete(public_path('uploads/farmers') . '/' . $farmer->photo);
        }
        $farmer->delete();
        return redirect()->route('admin.farmers')->with('status', 'Farmer has been deleted successfully.');
    }


    public function categories(Request $request)
    {
        $query = Category::withCount('products')->orderBy('id', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', "%{$request->name}%");
        }

        $categories = $query->paginate(10);
        return view('admin.category.categories', compact('categories'));
    }

    public function category_add()
    {
        return view('admin.category.category-add');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpg,jpeg|max:10048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $url = $this->GenerateCategoryThumbnailsImage($image, $file_name);
            $category->image = $url;
        }
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been added successfully.');
    }

    public function GenerateCategoryThumbnailsImage($image, $imageName)
    {
        $publicId = pathinfo($imageName, PATHINFO_FILENAME);
        return Cloudinary::uploadApi()->upload($image->getRealPath(), [
            'folder' => 'categories',
            'public_id' => $publicId
        ])['secure_url'];
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:10048',
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $url = $this->GenerateCategoryThumbnailsImage($image, $file_name);
            $category->image = $url;
        }
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been updated successfully.');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        if (File::exists(public_path('uploads/categories') . '/' . $category->image)) {
            File::delete(public_path('uploads/categories') . '/' . $category->image);
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category has been deleted successfully.');
    }

    public function products(Request $request)
    {
        $query = Product::with(['productTypes', 'primaryUnitPrice.unit'])->orderBy('created_at', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('SKU', 'LIKE', "%{$searchTerm}%");
            });
        }

        $products = $query->paginate(10);
        return view('admin.product.products', compact('products'));
    }

    public function product_add()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $regions = \App\Models\Region::select('id', 'name')->orderBy('name')->get();
        $farmers = \App\Models\Farmer::where('is_active', true)->select('id', 'name')->orderBy('name')->get();
        $units = \App\Models\Unit::orderBy('name')->get();
        $productTypes = \App\Models\ProductType::orderBy('name')->get();

        return view('admin.product.product-add', compact('categories', 'regions', 'farmers', 'units', 'productTypes'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name'              => 'required',
            'slug'              => 'required|unique:products,slug',
            'short_description' => 'required',
            'description'       => 'required',
            'SKU'               => 'required',
            'stock_status'      => 'required',
            'featured'          => 'required',
            'quantity'          => 'required',
            'organic_status'    => 'required',
            'harvest_period'    => 'required_if:organic_status,Organik',
            'shelf_life'        => 'required_if:organic_status,Organik',
            'production_date'   => 'required_if:organic_status,Non-Organik|nullable|date',
            'bpom_number'       => 'required_if:organic_status,Non-Organik|nullable|string',
            'composition'       => 'required_if:organic_status,Non-Organik|nullable|string',
            'expiry_date'       => 'required_if:organic_status,Non-Organik|nullable|date',
            'image'             => 'required|mimes:png,jpg,jpeg|max:10048',
            'category_id'       => 'required|integer|exists:categories,id',
            // New validations for product types and unit prices
            'product_types'     => 'required|array|min:1',
            'product_types.*'   => 'exists:product_types,id',
            'unit_prices'       => 'required|array|min:1',
            'unit_prices.*.unit_id' => 'required|exists:units,id',
            'unit_prices.*.regular_price' => 'required|numeric|min:0',
            'unit_prices.*.sale_price' => 'nullable|numeric|min:0',
            'unit_prices.*.minimum_order' => 'required|numeric|min:0.01',
            'images'            => 'nullable|array',
            'images.*'          => 'mimes:png,jpg,jpeg|max:10048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        // Remove old price fields - now using unit prices
        $product->regular_price = 0; // Will be deprecated
        $product->sale_price = 0; // Will be deprecated
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->region_id = $request->region_id;
        $product->farmer_id = $request->farmer_id;
        $product->organic_status = $request->organic_status;
        $product->harvest_period = $request->harvest_period;
        $product->shelf_life = $request->shelf_life;
        $product->production_date = $request->production_date;
        $product->bpom_number = $request->bpom_number;
        $product->composition = $request->composition;
        $product->expiry_date = $request->expiry_date;
        $product->storage_info = $request->storage_info;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $url = $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $url;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {
            $allowedfileExtion = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtion);
                if ($gcheck) {
                    $gfileName = $current_timestamp . "_" . $counter . "." . $gextension;
                    $url = $this->GenerateProductThumbnailImage($file, $gfileName);
                    array_push($gallery_arr, $url);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
        }
        $product->images = $gallery_images;
        $product->save();

        // Sync product types (many-to-many)
        $product->productTypes()->sync($request->product_types);

        // Create unit prices
        $hasPrimary = false;
        foreach ($request->unit_prices as $index => $unitPriceData) {
            // Check actual value, not just isset (isset returns true even for '0')
            $isPrimary = ($unitPriceData['is_primary'] ?? '0') == '1';

            // Ensure only one primary
            if ($isPrimary) {
                if ($hasPrimary) {
                    $isPrimary = false; // Skip if already have primary
                } else {
                    $hasPrimary = true;
                }
            }

            \App\Models\ProductUnitPrice::create([
                'product_id' => $product->id,
                'unit_id' => $unitPriceData['unit_id'],
                'regular_price' => $unitPriceData['regular_price'],
                'sale_price' => $unitPriceData['sale_price'] ?? null,
                'minimum_order' => $unitPriceData['minimum_order'],
                'is_primary' => $isPrimary,
            ]);
        }

        // If no primary was set, make the first one primary
        if (!$hasPrimary && $product->unitPrices()->count() > 0) {
            $product->unitPrices()->first()->update(['is_primary' => true]);
        }

        return redirect()->route('admin.products')->with('status', 'Product has been added successfully!');
    }

    public function GenerateProductThumbnailImage($image, $imageName)
    {
        $publicId = pathinfo($imageName, PATHINFO_FILENAME);
        return Cloudinary::uploadApi()->upload($image->getRealPath(), [
            'folder' => 'products',
            'public_id' => $publicId
        ])['secure_url'];
    }


    public function product_edit($id)
    {
        $product = Product::with(['productTypes', 'unitPrices.unit'])->find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $regions = \App\Models\Region::select('id', 'name')->orderBy('name')->get();
        $farmers = \App\Models\Farmer::where('is_active', true)->select('id', 'name')->orderBy('name')->get();
        $units = \App\Models\Unit::orderBy('name')->get();
        $productTypes = \App\Models\ProductType::orderBy('name')->get();

        return view('admin.product.product-edit', compact('product', 'categories', 'regions', 'farmers', 'units', 'productTypes'));
    }

    public function product_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $request->id,
            'short_description' => 'required',
            'description' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'organic_status'    => 'required',
            'harvest_period'    => 'required_if:organic_status,Organik',
            'shelf_life'        => 'required_if:organic_status,Organik',
            'production_date'   => 'required_if:organic_status,Non-Organik|nullable|date',
            'bpom_number'       => 'required_if:organic_status,Non-Organik|nullable|string',
            'composition'       => 'required_if:organic_status,Non-Organik|nullable|string',
            'expiry_date'       => 'required_if:organic_status,Non-Organik|nullable|date',
            'image' => 'mimes:png,jpg,jpeg|max:10048',
            'category_id' => 'required',
            // New validations
            'product_types' => 'required|array|min:1',
            'product_types.*' => 'exists:product_types,id',
            'unit_prices' => 'required|array|min:1',
            'unit_prices.*.unit_id' => 'required|exists:units,id',
            'unit_prices.*.regular_price' => 'required|numeric|min:0',
            'unit_prices.*.sale_price' => 'nullable|numeric|min:0',
            'unit_prices.*.minimum_order' => 'required|numeric|min:0.01',
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = 0; // Deprecated
        $product->sale_price = 0; // Deprecated
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->region_id = $request->region_id;
        $product->farmer_id = $request->farmer_id;
        $product->organic_status = $request->organic_status;
        $product->harvest_period = $request->harvest_period;
        $product->shelf_life = $request->shelf_life;
        $product->production_date = $request->production_date;
        $product->bpom_number = $request->bpom_number;
        $product->composition = $request->composition;
        $product->expiry_date = $request->expiry_date;
        $product->storage_info = $request->storage_info;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $url = $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $url;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {

            foreach (explode(',', $product->images) as $ofile) {
                // Skipping local file deletion
            }
            $allowedfileExtion = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtion);
                if ($gcheck) {
                    $gfileName = $current_timestamp . "_" . $counter . "." . $gextension;
                    $url = $this->GenerateProductThumbnailImage($file, $gfileName);
                    array_push($gallery_arr, $url);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
            $product->images = $gallery_images;
        }

        $product->save();

        // Sync product types
        $product->productTypes()->sync($request->product_types);

        // Delete old unit prices and create new ones
        $product->unitPrices()->delete();

        $hasPrimary = false;
        foreach ($request->unit_prices as $index => $unitPriceData) {
            // Check actual value, not just isset (isset returns true even for '0')
            $isPrimary = ($unitPriceData['is_primary'] ?? '0') == '1';

            if ($isPrimary) {
                if ($hasPrimary) {
                    $isPrimary = false;
                } else {
                    $hasPrimary = true;
                }
            }

            \App\Models\ProductUnitPrice::create([
                'product_id' => $product->id,
                'unit_id' => $unitPriceData['unit_id'],
                'regular_price' => $unitPriceData['regular_price'],
                'sale_price' => $unitPriceData['sale_price'] ?? null,
                'minimum_order' => $unitPriceData['minimum_order'],
                'is_primary' => $isPrimary,
            ]);
        }

        if (!$hasPrimary && $product->unitPrices()->count() > 0) {
            $product->unitPrices()->first()->update(['is_primary' => true]);
        }

        return redirect()->route('admin.products')->with('status', 'Product has been updated successfully!');
    }

    public function product_delete($id)
    {
        $product = Product::find($id);
        if (File::exists(public_path('uploads/products') . '/' . $product->image)) {
            File::delete(public_path('uploads/products') . '/' . $product->image);
        }
        if (File::exists(public_path('uploads/products/thumbnails') . '/' . $product->image)) {
            File::delete(public_path('uploads/products/thumbnails') . '/' . $product->image);
        }

        foreach (explode(',', $product->images) as $ofile) {
            if (File::exists(public_path('uploads/products') . '/' . $ofile)) {
                File::delete(public_path('uploads/products') . '/' . $ofile);
            }
            if (File::exists(public_path('uploads/products/thumbnails') . '/' . $ofile)) {
                File::delete(public_path('uploads/products/thumbnails') . '/' . $ofile);
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully!');
    }

    public function coupons(Request $request)
    {
        $query = Coupon::orderBy('expiry_date', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('code', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('type', 'LIKE', "%{$searchTerm}%");
            });
        }

        $coupons = $query->paginate(12);
        return view('admin.coupons.coupons', compact('coupons'));
    }

    public function coupon_add()
    {
        return view('admin.coupons.coupon-add');
    }

    public function coupon_store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('status', 'Coupon has been added successfully!');
    }

    public function coupon_edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupons.coupon-edit', compact('coupon'));
    }

    public function coupon_update(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = Coupon::find($request->id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status', 'Coupon has been updated successfully!');
    }

    public function coupon_delete($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('status', 'Coupon has been deleted successfully!');
    }

    public function orders(Request $request)
    {
        $query = Order::orderBy('created_at', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('id', 'LIKE', "%{$searchTerm}%");
            });
        }

        $orders = $query->paginate(12);
        return view('admin.order.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::find($order_id);
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('admin.order.order-details', compact('order', 'orderItems', 'transaction'));
    }

    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } else if ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        $order->save();

        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            if ($transaction) {
                $transaction->status = 'approved';
                $transaction->save();
            }
        }

        return back()->with("status", "status changed successfully!");
    }

    public function order_delete($id)
    {
        $order = Order::find($id);

        if ($order) {
            // Delete related order items
            OrderItem::where('order_id', $id)->delete();

            // Delete related transaction
            Transaction::where('order_id', $id)->delete();

            // Delete the order
            $order->delete();

            return redirect()->route('admin.orders')->with('status', 'Order deleted successfully!');
        }

        return redirect()->route('admin.orders')->with('error', 'Order not found!');
    }

    public function slides(Request $request)
    {
        $query = Slide::orderBy('id', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('subtitle_small', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('title_main', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('subtitle_large', 'LIKE', "%{$searchTerm}%");
            });
        }

        $slides = $query->paginate(12);
        return view('admin.slides.slides', compact('slides'));
    }

    public function slide_add()
    {
        return view('admin.slides.slide-add');
    }

    public function slide_store(Request $request)
    {
        $request->validate([
            'subtitle_small' => 'required',
            'title_main' => 'required',
            'subtitle_large' => 'required',
            'link' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10000',
            'status' => 'required',
        ]);

        $slide = new Slide();
        $slide->subtitle_small = $request->subtitle_small;
        $slide->title_main = $request->title_main;
        $slide->subtitle_large = $request->subtitle_large;
        $slide->link = $request->link;
        $slide->status = $request->status;

        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;
        $url = $this->GenerateSlidesThumbnailImage($image, $file_name);
        $slide->image = $url;
        $slide->save();

        return redirect()->route('admin.slides')->with('status', 'Slide has been added successfully!');
    }

    public function GenerateSlidesThumbnailImage($image, $imageName)
    {
        $publicId = pathinfo($imageName, PATHINFO_FILENAME);
        return Cloudinary::uploadApi()->upload($image->getRealPath(), [
            'folder' => 'slides',
            'public_id' => $publicId
        ])['secure_url'];
    }

    public function slide_edit($id)
    {
        $slide = Slide::find($id);
        return view('admin.slides.slide-edit', compact('slide'));
    }

    public function slide_update(Request $request)
    {
        $request->validate([
            'subtitle_small' => 'required',
            'title_main' => 'required',
            'subtitle_large' => 'required',
            'link' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10000',
            'status' => 'required',
        ]);

        $slide = Slide::find($request->id);
        $slide->subtitle_small = $request->subtitle_small;
        $slide->title_main = $request->title_main;
        $slide->subtitle_large = $request->subtitle_large;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $url = $this->GenerateSlidesThumbnailImage($image, $file_name);
            $slide->image = $url;
        }
        $slide->save();

        return redirect()->route('admin.slides')->with('status', 'Slide has been updated successfully!');
    }

    public function slide_delete($id)
    {
        $slide = Slide::find($id);
        if (File::exists(public_path('uploads/slides') . '/' . $slide->image)) {
            File::delete(public_path('uploads/slides') . '/' . $slide->image);
        }
        $slide->delete();
        return redirect()->route('admin.slides')->with('status', 'Slide has been deleted successfully!');
    }

    public function contact(Request $request)
    {
        $query = Contact::orderBy('created_at', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('comment', 'LIKE', "%{$searchTerm}%");
            });
        }

        $contacts = $query->paginate(10);
        return view('admin.contact.contacts', compact('contacts'));
    }

    public function contact_delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('admin.contacts')->with('status', 'Contact has been deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }

    // Review Management Methods
    public function reviews(Request $request)
    {
        $query = ProductReview::with(['product'])->orderBy('created_at', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('reviewer_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('reviewer_email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('review_text', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('product', function ($productQuery) use ($searchTerm) {
                        $productQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        $reviews = $query->paginate(10);
        return view('admin.reviews', compact('reviews'));
    }


    public function deleteReview($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();
        return redirect()->route('admin.reviews')->with('status', 'Review deleted successfully!');
    }

    // Analytics Dashboard
    public function analytics()
    {
        // Revenue trend (last 30 days)
        $revenueTrend = Order::selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->where('status', 'delivered')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // Revenue by category
        $categoryRevenue = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->get();

        // Customer insights
        $totalCustomers = DB::table('users')->where('utype', 'USR')->count();
        $newCustomersThisMonth = DB::table('users')
            ->where('utype', 'USR')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Today's statistics
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
            ->where('status', 'delivered')
            ->sum('total');
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        // Regional analytics
        $regionalSales = DB::table('products')
            ->join('regions', 'products.region_id', '=', 'regions.id')
            ->join('farmers', 'products.farmer_id', '=', 'farmers.id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('farmers.name as farmer_name, regions.name, SUM(order_items.quantity * order_items.price) as revenue')
            ->groupBy('farmers.id', 'farmers.name', 'regions.id', 'regions.name')
            ->orderByDesc('revenue')
            ->get();

        return view('admin.analytics', compact(
            'revenueTrend',
            'topProducts',
            'categoryRevenue',
            'totalCustomers',
            'newCustomersThisMonth',
            'todayRevenue',
            'todayOrders',
            'regionalSales'
        ));
    }

    // ========================================
    // SLIDE SPLITS CRUD (Shop Page Banners)
    // ========================================

    public function slide_splits(Request $request)
    {
        $query = SlideSplit::orderBy('created_at', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('subtitle', 'LIKE', "%{$searchTerm}%");
            });
        }

        $slideSplits = $query->paginate(12);
        return view('admin.slides.slide-splits', compact('slideSplits'));
    }

    public function slide_split_add()
    {
        return view('admin.slides.slide-split-add');
    }

    public function slide_split_store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'background_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'background_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10000',
            'status' => 'required|boolean',
        ]);

        $slideSplit = new SlideSplit();
        $slideSplit->title = $request->title;
        $slideSplit->subtitle = $request->subtitle;
        $slideSplit->background_color = $request->background_color;
        $slideSplit->status = $request->status;

        $image = $request->file('background_image');
        $file_extension = $image->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $url = $this->GenerateSlideSplitImage($image, $file_name);
        $slideSplit->background_image = $url;
        $slideSplit->save();

        return redirect()->route('admin.slide.splits')->with('status', 'Slide Split has been added successfully!');
    }

    public function GenerateSlideSplitImage($image, $imageName)
    {
        $publicId = pathinfo($imageName, PATHINFO_FILENAME);
        return Cloudinary::uploadApi()->upload($image->getRealPath(), [
            'folder' => 'slide-splits',
            'public_id' => $publicId
        ])['secure_url'];
    }

    public function slide_split_edit($id)
    {
        $slideSplit = SlideSplit::find($id);
        return view('admin.slides.slide-split-edit', compact('slideSplit'));
    }

    public function slide_split_update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'background_color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10000',
            'status' => 'required|boolean',
        ]);

        $slideSplit = SlideSplit::find($request->id);
        $slideSplit->title = $request->title;
        $slideSplit->subtitle = $request->subtitle;
        $slideSplit->background_color = $request->background_color;
        $slideSplit->status = $request->status;

        if ($request->hasFile('background_image')) {
            $image = $request->file('background_image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $url = $this->GenerateSlideSplitImage($image, $file_name);
            $slideSplit->background_image = $url;
        }
        $slideSplit->save();

        return redirect()->route('admin.slide.splits')->with('status', 'Slide Split has been updated successfully!');
    }

    public function slide_split_delete($id)
    {
        $slideSplit = SlideSplit::find($id);
        if (File::exists(public_path('uploads/slide-splits') . '/' . $slideSplit->background_image)) {
            File::delete(public_path('uploads/slide-splits') . '/' . $slideSplit->background_image);
        }
        $slideSplit->delete();
        return redirect()->route('admin.slide.splits')->with('status', 'Slide Split has been deleted successfully!');
    }

    // ========================================
    // USER MANAGEMENT
    // ========================================

    public function users(Request $request)
    {
        $query = User::where('utype', 'USR')->orderBy('created_at', 'DESC');

        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('mobile', 'LIKE', "%{$searchTerm}%");
            });
        }

        $users = $query->paginate(12);
        return view('admin.user.users', compact('users'));
    }

    public function user_details($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.user-details', compact('user'));
    }

    public function user_block($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();
        return back()->with('status', 'User has been blocked successfully!');
    }

    public function user_unblock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false;
        $user->save();
        return back()->with('status', 'User has been unblocked successfully!');
    }

    // ========================================
    // RETURN REQUESTS MANAGEMENT
    // ========================================

    public function returns(Request $request)
    {
        $query = \App\Models\ReturnRequest::with(['order', 'user'])
            ->orderBy('created_at', 'DESC');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('order_id', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        $returnRequests = $query->paginate(12);
        return view('admin.return.returns', compact('returnRequests'));
    }

    public function return_details($id)
    {
        $returnRequest = \App\Models\ReturnRequest::with(['order.orderItems.product', 'user'])
            ->findOrFail($id);
        return view('admin.return.return-details', compact('returnRequest'));
    }

    public function update_return_status(Request $request)
    {
        $request->validate([
            'return_id' => 'required|exists:return_requests,id',
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        $returnRequest = \App\Models\ReturnRequest::findOrFail($request->return_id);
        $returnRequest->status = $request->status;

        if ($request->filled('admin_notes')) {
            $returnRequest->admin_notes = $request->admin_notes;
        }

        $returnRequest->save();

        return back()->with('success', 'Status pengajuan pengembalian berhasil diperbarui!');
    }

    // ========================================
    // TESTIMONIAL MANAGEMENT
    // ========================================

    public function testimonials(Request $request)
    {
        $query = Contact::where('message_type', 'testimonial')
            ->orderBy('created_at', 'DESC');

        // Search functionality
        if ($request->filled('name')) {
            $searchTerm = $request->name;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('comment', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by approval status
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        $testimonials = $query->paginate(12);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function testimonial_toggle_approval($id)
    {
        $testimonial = Contact::findOrFail($id);

        // Toggle approval status
        $testimonial->is_approved = !$testimonial->is_approved;
        $testimonial->approved_at = $testimonial->is_approved ? now() : null;
        $testimonial->save();

        $status = $testimonial->is_approved ? 'approved' : 'unapproved';
        return back()->with('status', "Testimonial has been {$status} successfully!");
    }

    public function testimonial_delete($id)
    {
        $testimonial = Contact::findOrFail($id);
        $testimonial->delete();
        return redirect()->route('admin.testimonials')->with('status', 'Testimonial has been deleted successfully!');
    }
}
