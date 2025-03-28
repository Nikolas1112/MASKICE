<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WriteOffSuppliesRequest;
use App\Models\PhysicalShop;
use App\Repositories\Interfaces\Admin\WriteOffSuppliesInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class WriteOffSuppliesController extends Controller
{
    private WriteOffSuppliesInterface $writeOffSupplies;

    public function __construct(
        WriteOffSuppliesInterface $writeOffSupplies
    ) {
        $this->writeOffSupplies = $writeOffSupplies;
    }

    public function index()
    {
     
        try {
            $data = [
                'write_off_supplies' => $this->writeOffSupplies->all()
            ];

            return view('admin.writeoff_supplies.index', $data);
        } catch (\Exception $exception) {
            Toastr::error($exception->getMessage());
            return back();
        }
    }

    public function create()
    {
        $physicalShops = PhysicalShop::select('id','name')->get();
        return view('admin.writeoff_supplies.form',[
            'physical_shops' => $physicalShops
        ]);
    }

    public function store(WriteOffSuppliesRequest $request)
    {
        if (config('app.demo_mode')):
            Toastr::info(__('This function is disabled in demo server.'));
            return redirect()->back();
        endif;
        try {
            $this->writeOffSupplies->store($request);

            Toastr::success(__('Created Successfully'));
            return redirect()->route('writeoff.supplies.index');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }

    }


    public function edit($id, Request $request)
    {
        $physicalShops = PhysicalShop::select('id','name')->get();
        try {
            $data = [
                'writeoff_supplies' => $this->writeOffSupplies->find($id),
                'r'    => $request->r != ''? $request->r : $request->server('HTTP_REFERER'),
                'physical_shops'     => $physicalShops
            ];
            return view('admin.writeoff_supplies.form', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }
    }

    public function update(WriteOffSuppliesRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        if (config('app.demo_mode')):
            Toastr::info(__('This function is disabled in demo server.'));
            return redirect()->back();
        endif;

        try {
            $this->writeOffSupplies->update($request, $id);
            Toastr::success(__('Updated Successfully'));
            return redirect()->route('writeoff.supplies.index');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }
    }

}