<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\SupplierInterface;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use App\Http\Requests\Admin\SupplierRequest;

class SupplierController extends Controller
{
    protected $supplier;

    public function __construct(SupplierInterface $supplier)
    {
        $this->supplier = $supplier;
    }

    public function index()
    {
        try {
            $suppliers = [
                'suppliers' => $this->supplier->getAll()
            ];
            return view('admin.supplier.index', $suppliers);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('admin.supplier.form');
    }

    public function store(SupplierRequest $request)
    {
        try {
            $this->supplier->create($request->all());
            Toastr::success('supplier added successfully!');
            return redirect()->route('supplier.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $edit = [
                'edit' => $this->supplier->findById($id)
            ];
            return view('admin.supplier.form', $edit);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->route('supplier.index');
        }
    }

    public function update(SupplierRequest $request, $id)
    {
        try {
            $updated = $this->supplier->update($id, $request->all());

            if ($updated) {
                Toastr::success('supplier updated successfully!');
            } else {
                Toastr::warning('No changes made.');
            }

            return redirect()->route('supplier.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
