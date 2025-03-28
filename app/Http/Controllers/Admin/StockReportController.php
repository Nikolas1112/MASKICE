<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    /**
     * Display the overview tab of the stock report.
     */
    public function overview(Request $request)
    {
        $filter = $request->input('filter');

        $products = Product::with('stock')
            ->when($filter, function($query, $filter) {
                return $query->where(function($q) use ($filter) {
                    $q->whereHas('productLanguages', function ($q2) use ($filter) {
                        $q2->where('name', 'like', "%{$filter}%");
                    })
                    ->orWhere('barcode', 'like', "%{$filter}%");
                });
            })
            ->paginate(10);

        return view('admin.stock_report.overview', compact('products'));
    }

    /**
     * Display the stock movement tab of the stock report.
     */
    public function movement()
    {
        // Retrieve stock movement data with associated product details.
        $stockMovements = collect([]);
    
        return view('admin.stock_report.movement', compact('stockMovements'));
    }
    

    /**
     * Display the stock verification tab of the stock report.
     */
    public function verification()
    {
        // Retrieve stock verification data using the StockVerification model.
        // We assume each verification record is linked to a product and a verifier (user).
        $verifications = collect([]);

        return view('admin.stock_report.verification', compact('verifications'));
    }
}
