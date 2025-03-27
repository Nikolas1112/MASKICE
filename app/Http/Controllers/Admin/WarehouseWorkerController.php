<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\WarehouseWorkerInterface;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class WarehouseWorkerController extends Controller
{
    protected $warehouseworker;

    public function __construct(WarehouseWorkerInterface $warehouseworker)
    {
        $this->warehouseworker = $warehouseworker;
    }

    public function index()
    {
        try {
            $groups = ['warehouse_worker', 'empolyee', 'cashier', 'moderator'];
            $warehouseworkers = [
                'warehouseworkers' => $this->warehouseworker->getAll(10, $groups)
            ];
            return view('admin.warehouseworker.index', $warehouseworkers);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }
}
