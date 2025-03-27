<?php
namespace App\Repositories\Interfaces\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface WarehouseWorkerInterface {
    public function getAll(int $perPage = 10): LengthAwarePaginator; 

 
}
