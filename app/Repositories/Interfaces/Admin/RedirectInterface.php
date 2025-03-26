<?php
namespace App\Repositories\Interfaces\Admin;

use App\Models\Redirect;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RedirectInterface {
    public function getAll(int $perPage = 10): LengthAwarePaginator; 

    public function findById(int $id): ?Redirect;

    public function create(array $data): Redirect;

    public function update(int $id, array $data): bool;
}
