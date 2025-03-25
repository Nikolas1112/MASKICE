<?php

namespace App\Http\Controllers\Admin;

use App\Models\PhysicalShop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\PhysicalShopInterface;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use App\Http\Requests\Admin\PhysicalShopRequest;

class PhysicalShopController extends Controller
{
    protected $physicalShop;

    public function __construct(PhysicalShopInterface $physicalShop)
    {
        $this->physicalShop = $physicalShop;
    }

    public function index()
    {
        try {
            $physicalShops = [
                'physicalShops' => $this->physicalShop->getAll()
            ];
            return view('admin.physical_shops.index', $physicalShops);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('admin.physical_shops.form');
    }

    public function store(PhysicalShopRequest $request)
    {
        try {
            $this->physicalShop->create($request->all());
            Toastr::success('Shop added successfully!');
            return redirect()->route('physical_shops.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $edit = [
                'edit' => $this->physicalShop->findById($id)
            ];
            return view('admin.physical_shops.form', $edit);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->route('physical_shops.index');
        }
    }

    public function update(PhysicalShopRequest $request, $id)
    {
        try {
            $updated = $this->physicalShop->update($id, $request->all());

            if ($updated) {
                Toastr::success('Shop updated successfully!');
            } else {
                Toastr::warning('No changes made.');
            }

            return redirect()->route('physical_shops.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
