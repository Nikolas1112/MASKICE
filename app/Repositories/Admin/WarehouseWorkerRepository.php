<?php
namespace App\Repositories\Admin;

use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\Admin\WarehouseWorkerInterface;

class WarehouseWorkerRepository implements WarehouseWorkerInterface
{
    public function getAll(int $perPage = 10, array $groups = []): LengthAwarePaginator
    {
        $query = Employee::query();

        if (!empty($groups)) {
            $query->whereIn('group', $groups);
        }

        return $query->paginate($perPage);
    }
}
