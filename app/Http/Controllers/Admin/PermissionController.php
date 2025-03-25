<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\PermissionInterface;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use App\Http\Requests\Admin\PermissionRequest;

class PermissionController extends Controller
{
    protected $permission;

    public function __construct(PermissionInterface $permission)
    {
        $this->permission = $permission;
    }

    public function index()
    {
        try {
            $permissions = [
                'permissions' => $this->permission->getAll()
            ];
            return view('admin.permission.index', $permissions);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('admin.permission.form');
    }

    public function store(PermissionRequest $request)
    {
        try {
            $attribute = strtolower(str_replace(' ', '_', $request->attribute));
            $permissions = $request->permissions ?? []; 

            $keywords = [];
            foreach ($permissions as $perm) {
                $keywords[$perm] = $attribute . '_' . $perm;
            }

            $data = [
                'attribute' => $attribute,
                'keywords'  => json_encode($keywords),
            ];

            $this->permission->create($data);
            Toastr::success('Permission added successfully!');
            return redirect()->route('permission.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function edit($id)
    {
        try {
            $edit = [
                'edit' => $this->permission->findById($id)
            ];
            return view('admin.permission.form', $edit);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->route('permission.index');
        }
    }

    public function update(PermissionRequest $request, $id)
    {
        try {
            $attribute = strtolower(str_replace(' ', '_', $request->attribute)); 
            $permissions = $request->permissions ?? []; 

            $keywords = [];
            foreach ($permissions as $perm) {
                $keywords[$perm] = $attribute . '_' . $perm;
            }

            $data = [
                'attribute' => $attribute,
                'keywords'  => json_encode($keywords),
            ];

            $this->permission->update($id, $data);
            Toastr::success('Permission updated successfully!');
            return redirect()->route('permission.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

}
