<?php
namespace App\Repositories\Admin;

use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\Admin\EmployeeInterface;

class EmployeeRepository implements EmployeeInterface {
   
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Employee::paginate($perPage);
    }

    public function findById(int $id): ?Employee
    {
        return Employee::find($id);
    }

    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $employee = Employee::find($id);
        if ($employee) {
            return $employee->update($data);
        }
        return false;
    }
}
