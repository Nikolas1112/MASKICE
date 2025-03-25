<?php 

namespace App\Repositories\Interfaces\Admin;

use App\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PermissionInterface {
    public function getAll(int $perPage = 10): LengthAwarePaginator; 

    public function findById(int $id): ?Permission;

    public function create(array $data): Permission;

    public function update(int $id, array $data): bool;
    
}
