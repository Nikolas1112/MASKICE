<?php

namespace App\Repositories\Admin;
use App\Models\Permission;
use App\Repositories\Interfaces\Admin\PermissionInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PermissionRepository implements PermissionInterface {

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Permission::paginate($perPage);
    }

    public function findById(int $id): ?Permission
    {
        return Permission::find($id);
    }

    public function create(array $data): Permission
    {
        $data['keywords'] = json_decode($data['keywords'], true);
        return Permission::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $permission = Permission::find($id);
        if ($permission) {
            $data['keywords'] = json_decode($data['keywords'], true);
            return $permission->update($data);
        }
        return false;
    }

}
