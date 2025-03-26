<?php

namespace App\Http\Controllers\Admin;

use App\Models\Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Admin\RedirectInterface;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use App\Http\Requests\Admin\RedirectRequest;

class RedirectController extends Controller
{
    protected $redirect;

    public function __construct(RedirectInterface $redirect)
    {
        $this->redirect = $redirect;
    }

    public function index()
    {
        try {
            $redirects = [
                'redirects' => $this->redirect->getAll()
            ];
            return view('admin.redirect.index', $redirects);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('admin.redirect.form');
    }

    public function store(RedirectRequest $request)
    {
        try {
            $this->redirect->create($request->all());
            Toastr::success('Shop added successfully!');
            return redirect()->route('redirect.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $edit = [
                'edit' => $this->redirect->findById($id)
            ];
            return view('admin.redirect.form', $edit);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->route('redirect.index');
        }
    }

    public function update(RedirectRequest $request, $id)
    {
        try {
            $updated = $this->redirect->update($id, $request->all());

            if ($updated) {
                Toastr::success('redirect updated successfully!');
            } else {
                Toastr::warning('No changes made.');
            }

            return redirect()->route('redirect.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
