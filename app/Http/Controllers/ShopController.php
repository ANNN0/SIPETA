<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size') ? $request->query('size') : 25;
        $o_column = "";
        $o_order = "";
        $order = $request->query('order') ? $request->query('order') : -1;
        $f_categories = $request->query('categories');
        $f_regions = $request->query('regions');
        $f_product_types = $request->query('product_types'); // New: product types filter
        $min_price = $request->query('min') ? $request->query('min') : 1;
        $max_price = $request->query('max') ? $request->query('max') : 100000000; // Increased for unit-based pricing (e.g. ton prices)

        // New parameters
        $search = $request->query('search');
        $sort = $request->query('sort');

        // Legacy order handling
        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'sale_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'sale_price';
                $o_order = 'DESC';
                break;
            default:
                $o_column = 'id';
                $o_order = 'DESC';
        }

        $categories = Category::orderBy('name', 'ASC')->get();
        $regions = Region::orderBy('name', 'ASC')->get();
        $productTypes = \App\Models\ProductType::withCount('products')->orderBy('name', 'ASC')->get(); // New: load product types with count

        $products = Product::query();

        // Search filter
        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhereHas('farmer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('region', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('productTypes', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }


        // Category filter
        $products->where(function ($query) use ($f_categories) {
            $query->whereIn('category_id', explode(',', $f_categories))->orWhereRaw("'" . $f_categories . "'=''");
        });

        // Region filter
        $products->where(function ($query) use ($f_regions) {
            $query->whereIn('region_id', explode(',', $f_regions))->orWhereRaw("'" . $f_regions . "'=''");
        });

        // Price range filter (TEMPORARILY DISABLED - needs update for unit-based pricing)
        // TODO: Update to check primaryUnitPrice instead of deprecated regular_price/sale_price
        // $products->where(function ($query) use ($min_price, $max_price) {
        //     $query->whereBetween('regular_price', [$min_price, $max_price])
        //         ->orWhereBetween('sale_price', [$min_price, $max_price]);
        // });

        // Quick filters
        if ($request->has('best_rated')) {
            // Filter products that have at least one 4.5+ review
            $products->whereHas('approvedReviews', function ($query) {
                $query->selectRaw('AVG(rating) as avg_rating')
                    ->groupBy('product_id')
                    ->havingRaw('AVG(rating) >= 4.5');
            });
        }

        if ($request->has('on_sale')) {
            $products->whereColumn('sale_price', '<', 'regular_price');
        }

        if ($request->has('organic')) {
            $products->where('organic_status', 'like', '%Organik%');
        }

        if ($request->has('ready_stock')) {
            $products->where('stock_status', 'instock')
                ->where('quantity', '>', 0);
        }

        // Product Types filter (New)
        if ($f_product_types && is_array($f_product_types) && count($f_product_types) > 0) {
            $products->whereHas('productTypes', function ($q) use ($f_product_types) {
                $q->whereIn('product_types.id', $f_product_types);
            });
        }

        // Advanced sort options
        if ($sort) {
            switch ($sort) {
                case 'price_asc':
                    // Sort by primary unit price (ascending)
                    $products->leftJoin('product_unit_prices', function ($join) {
                        $join->on('products.id', '=', 'product_unit_prices.product_id')
                            ->where('product_unit_prices.is_primary', '=', 1);
                    })
                        ->orderByRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) ASC')
                        ->select('products.*');
                    break;
                case 'price_desc':
                    // Sort by primary unit price (descending)
                    $products->leftJoin('product_unit_prices', function ($join) {
                        $join->on('products.id', '=', 'product_unit_prices.product_id')
                            ->where('product_unit_prices.is_primary', '=', 1);
                    })
                        ->orderByRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) DESC')
                        ->select('products.*');
                    break;
                case 'newest':
                    $products->orderBy('created_at', 'desc');
                    break;
                case 'rating':
                    // Sort by average rating (requires approved reviews)
                    $products->withAvg('approvedReviews as avg_rating', 'rating')
                        ->orderByDesc('avg_rating');
                    break;
                case 'reviews':
                    // Sort by review count (most reviewed first)
                    $products->withCount('approvedReviews')
                        ->orderByDesc('approved_reviews_count');
                    break;
                default:
                    $products->orderBy($o_column, $o_order);
            }
        } else {
            $products->orderBy($o_column, $o_order);
        }

        // Eager load relationships for display
        $products = $products->with(['productTypes', 'primaryUnitPrice.unit'])->paginate($size);

        // Check if this is an AJAX request for search suggestions
        if ($request->query('suggestion') == '1') {
            // Get limited results for suggestions (max 8 items)
            $suggestionQuery = Product::query();

            // Apply same search logic
            if ($search) {
                $suggestionQuery->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhereHas('farmer', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('region', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('productTypes', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            }

            $suggestions = $suggestionQuery
                ->with(['category', 'primaryUnitPrice.unit'])
                ->take(8)
                ->get()
                ->map(function ($product) {
                    return [
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'image' => $product->image,
                        'price' => $this->getPrimaryPrice($product),
                        'category' => $product->category ? $product->category->name : 'Produk'
                    ];
                });

            return response()->json($suggestions);
        }

        // Check if this is an AJAX request
        if ($request->query('ajax') == '1') {
            // Return JSON response for AJAX
            $productsHtml = view('shop.partials.products', compact('products'))->render();
            $paginationHtml = $products->withQueryString()->links('pagination::bootstrap-5');

            return response()->json([
                'success' => true,
                'productsHtml' => $productsHtml,
                'paginationHtml' => $paginationHtml,
                'resultCount' => $products->total()
            ]);
        }

        // Get active slide splits for shop banner
        $slideSplits = \App\Models\SlideSplit::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('shop.shop', compact('products', 'categories', 'regions', 'productTypes', 'f_categories', 'f_regions', 'f_product_types', 'order', 'size', 'min_price', 'max_price', 'slideSplits'));
    }

    public function product_details($product_slug, Request $request)
    {
        $sort = $request->query('sort', 'latest'); // Default: latest (newest first)

        $product = Product::where('slug', $product_slug)
            ->with([
                'approvedReviews',
                'unitPrices.unit',      // Eager load unit prices with units for selector
                'productTypes'          // Load product types for display
            ])
            ->first();

        // Get prev/next products based on sort order
        [$prevProduct, $nextProduct] = $this->getNavigationProducts($product, $sort);

        $rproducts = Product::where('slug', '<>', $product_slug)
            ->with('primaryUnitPrice.unit')
            ->get()
            ->take(8);

        $reviewCount = $product->approvedReviews->count();

        // Recently Viewed Products - Session based tracking
        $recentlyViewedIds = session()->get('recently_viewed', []);

        // Get recently viewed products (exclude current product)
        $recentlyViewed = collect();
        if (!empty($recentlyViewedIds)) {
            $recentlyViewed = Product::whereIn('id', $recentlyViewedIds)
                ->where('id', '!=', $product->id)
                ->with('primaryUnitPrice.unit')
                ->get()
                ->sortBy(function ($item) use ($recentlyViewedIds) {
                    return array_search($item->id, $recentlyViewedIds);
                })
                ->take(6);
        }

        // Add current product to recently viewed (at the beginning)
        $recentlyViewedIds = array_diff($recentlyViewedIds, [$product->id]); // Remove if exists
        array_unshift($recentlyViewedIds, $product->id); // Add to beginning
        $recentlyViewedIds = array_slice($recentlyViewedIds, 0, 10); // Keep only last 10
        session()->put('recently_viewed', $recentlyViewedIds);

        return view('shop.details', compact('product', 'rproducts', 'reviewCount', 'prevProduct', 'nextProduct', 'sort', 'recentlyViewed'));
    }

    /**
     * Get previous and next products based on sort order
     */
    private function getNavigationProducts($currentProduct, $sort)
    {
        switch ($sort) {
            case 'latest':
                // Newer products = PREV, Older products = NEXT
                $prevProduct = Product::where('created_at', '>', $currentProduct->created_at)
                    ->orderBy('created_at', 'ASC')
                    ->first();
                $nextProduct = Product::where('created_at', '<', $currentProduct->created_at)
                    ->orderBy('created_at', 'DESC')
                    ->first();
                break;

            case 'oldest':
                // Older products = PREV, Newer products = NEXT
                $prevProduct = Product::where('created_at', '<', $currentProduct->created_at)
                    ->orderBy('created_at', 'DESC')
                    ->first();
                $nextProduct = Product::where('created_at', '>', $currentProduct->created_at)
                    ->orderBy('created_at', 'ASC')
                    ->first();
                break;

            case 'price_asc':
                // List: Cheap → Expensive (top to bottom)
                // PREV goes UP to cheaper (<), NEXT goes DOWN to expensive (>)
                $currentPrice = $this->getPrimaryPrice($currentProduct);

                $prevProduct = Product::join('product_unit_prices', function ($join) {
                    $join->on('products.id', '=', 'product_unit_prices.product_id')
                        ->where('product_unit_prices.is_primary', 1);
                })
                    ->selectRaw('products.*, COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) as price')
                    ->whereRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) < ?', [$currentPrice])
                    ->orderByRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) DESC')
                    ->first();

                $nextProduct = Product::join('product_unit_prices', function ($join) {
                    $join->on('products.id', '=', 'product_unit_prices.product_id')
                        ->where('product_unit_prices.is_primary', 1);
                })
                    ->selectRaw('products.*, COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) as price')
                    ->whereRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) > ?', [$currentPrice])
                    ->orderByRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) ASC')
                    ->first();
                break;

            case 'price_desc':
                // List: Expensive → Cheap (top to bottom)
                // PREV goes UP to expensive (>), NEXT goes DOWN to cheap (<)
                $currentPrice = $this->getPrimaryPrice($currentProduct);

                $prevProduct = Product::join('product_unit_prices', function ($join) {
                    $join->on('products.id', '=', 'product_unit_prices.product_id')
                        ->where('product_unit_prices.is_primary', 1);
                })
                    ->selectRaw('products.*, COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) as price')
                    ->whereRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) > ?', [$currentPrice])
                    ->orderByRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) ASC')
                    ->first();

                $nextProduct = Product::join('product_unit_prices', function ($join) {
                    $join->on('products.id', '=', 'product_unit_prices.product_id')
                        ->where('product_unit_prices.is_primary', 1);
                })
                    ->selectRaw('products.*, COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) as price')
                    ->whereRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) < ?', [$currentPrice])
                    ->orderByRaw('COALESCE(product_unit_prices.sale_price, product_unit_prices.regular_price) DESC')
                    ->first();
                break;

            case 'rating':
                // List: High rating → Low rating (top to bottom)
                // PREV goes UP to higher rating (>), NEXT goes DOWN to lower rating (<)
                $currentRating = $currentProduct->approvedReviews()->avg('rating') ?? 0;

                $prevProduct = Product::withAvg('approvedReviews as avg_rating', 'rating')
                    ->havingRaw('COALESCE(avg_rating, 0) > ?', [$currentRating])
                    ->orderBy('avg_rating', 'ASC')
                    ->first();

                $nextProduct = Product::withAvg('approvedReviews as avg_rating', 'rating')
                    ->havingRaw('COALESCE(avg_rating, 0) < ?', [$currentRating])
                    ->orderBy('avg_rating', 'DESC')
                    ->first();
                break;

            case 'reviews':
                // List: Many reviews → Few reviews (top to bottom)  
                // PREV goes UP to more reviews (>), NEXT goes DOWN to fewer reviews (<)
                $currentReviewCount = $currentProduct->approvedReviews()->count();

                $prevProduct = Product::withCount('approvedReviews')
                    ->having('approved_reviews_count', '>', $currentReviewCount)
                    ->orderBy('approved_reviews_count', 'ASC')
                    ->first();

                $nextProduct = Product::withCount('approvedReviews')
                    ->having('approved_reviews_count', '<', $currentReviewCount)
                    ->orderBy('approved_reviews_count', 'DESC')
                    ->first();
                break;

            default:
                // Default to ID-based navigation
                $prevProduct = Product::where('id', '<', $currentProduct->id)
                    ->orderBy('id', 'DESC')
                    ->first();
                $nextProduct = Product::where('id', '>', $currentProduct->id)
                    ->orderBy('id', 'ASC')
                    ->first();
        }

        return [$prevProduct, $nextProduct];
    }

    /**
     * Get primary unit price for a product
     */
    private function getPrimaryPrice($product)
    {
        $primaryUnit = $product->primaryUnitPrice;
        if (!$primaryUnit) {
            return 0;
        }
        return $primaryUnit->sale_price ?? $primaryUnit->regular_price ?? 0;
    }
}
