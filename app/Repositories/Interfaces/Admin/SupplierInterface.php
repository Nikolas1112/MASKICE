<?php

namespace App\Repositories\Interfaces\Admin;

use App\Models\Supplier;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SupplierInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator; 

    public function findById(int $id): ?Supplier;

    public function create(array $data): Supplier;

    public function update(int $id, array $data): bool;
}

