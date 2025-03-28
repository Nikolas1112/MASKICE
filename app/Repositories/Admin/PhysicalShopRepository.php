<?php

namespace App\Repositories\Admin;

use App\Models\PhysicalShop;
use App\Repositories\Interfaces\Admin\PhysicalShopInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PhysicalShopRepository implements PhysicalShopInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return PhysicalShop::whereIsWebShop(false)->paginate($perPage);
    }

    public function findById(int $id): ?PhysicalShop
    {
        return PhysicalShop::find($id);
    }

    public function create(array $data): PhysicalShop
    {
        return PhysicalShop::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $shop = PhysicalShop::find($id);
        if ($shop) {
            return $shop->update($data); 
        }
        return false; 
    }
}



