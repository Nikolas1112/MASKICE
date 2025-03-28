<?php

namespace App\Repositories\Admin;

use App\Models\Supplier;
use App\Repositories\Interfaces\Admin\SupplierInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupplierRepository implements SupplierInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Supplier::paginate($perPage);
    }

    public function findById(int $id): ?Supplier
    {
        return Supplier::find($id);
    }

    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $shop = Supplier::find($id);
        if ($shop) {
            return $shop->update($data); 
        }
        return false; 
    }
}



