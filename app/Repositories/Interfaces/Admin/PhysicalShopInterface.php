<?php

namespace App\Repositories\Interfaces\Admin;

use App\Models\PhysicalShop;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PhysicalShopInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator; 

    public function findById(int $id): ?PhysicalShop;

    public function create(array $data): PhysicalShop;

    public function update(int $id, array $data): bool;
}

