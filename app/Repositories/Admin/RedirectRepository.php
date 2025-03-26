<?php
namespace App\Repositories\Admin;

use App\Models\Redirect;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\Admin\RedirectInterface;

class RedirectRepository implements RedirectInterface {
   
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return Redirect::paginate($perPage);
    }

    public function findById(int $id): ?Redirect
    {
        return Redirect::find($id);
    }

    public function create(array $data): Redirect
    {
        return Redirect::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $redirect = Redirect::find($id);
        if ($redirect) {
            return $redirect->update($data);
        }
        return false;
    }
}
