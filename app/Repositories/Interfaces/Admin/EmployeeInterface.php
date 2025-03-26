<?php
namespace App\Repositories\Interfaces\Admin;

use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EmployeeInterface {
    public function getAll(int $perPage = 10): LengthAwarePaginator; 

    public function findById(int $id): ?Employee;

    public function create(array $data): Employee;

    public function update(int $id, array $data): bool;
}
