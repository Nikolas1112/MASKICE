<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;  // Warehouse Model
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\SellerProfile;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = SellerProfile::select('id', 'shop_name as name', 'address')->paginate(10);
        return view('admin.warehouse.index', compact('warehouses'));
    }
}
