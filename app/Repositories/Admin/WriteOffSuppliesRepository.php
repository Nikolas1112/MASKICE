<?php

namespace App\Repositories\Admin;

use App\Models\ProductStock;
use App\Models\WriteOffSupplies;
use App\Repositories\Interfaces\Admin\WriteOffSuppliesInterface;

class WriteOffSuppliesRepository implements WriteOffSuppliesInterface
{

    public function __construct() {}

    public function paginate($limit)
    {
        return $this->all()->paginate($limit);
    }

    public function get($id)
    {
        return WriteOffSupplies::find($id);
    }

    public function all()
    {
        return WriteOffSupplies::all();
    }

    public function find($id)
    {
        return WriteOffSupplies::find($id);
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update($request, $id)
    {
        $writeOff = WriteOffSupplies::find($id);
        $writeOff->shop_name = $request->shop_name;
        $writeOff->product_sku_code =  $request->product_sku_code;
        // $writeOff->writeoff_quantities = $request->writeoff_quantities;
        $writeOff->reason = $request->reason;
        $writeOff->added_at = $request->added_at;

        $writeOff->save();
        return $writeOff;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function store($request)
    {
        $writeOff = new WriteOffSupplies();
        $writeOff->shop_name = $request->shop_name;
        $writeOff->product_sku_code =  $request->product_sku_code;
        $writeOff->writeoff_quantities = $request->writeoff_quantities;
        $writeOff->reason = $request->reason;
        $writeOff->added_at = $request->added_at;

        $writeOff->save();
        if (!empty($writeOff->product_sku_code)) {
            $productStock = ProductStock::where('sku', $writeOff->product_sku_code)->first();
            if ($productStock) {
                $currentStock =  $productStock->current_stock;
                $writeOffQuantities = $request->writeoff_quantities;
                $remainStocks = $currentStock - $writeOffQuantities;
                $productStock->update(['current_stock' => $remainStocks]);
            }
        }
    }
}
