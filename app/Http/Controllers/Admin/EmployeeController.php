<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\Interfaces\Admin\EmployeeInterface;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use App\Http\Requests\Admin\EmployeeRequest;

class EmployeeController extends Controller {
    private $employees;

    public function __construct(EmployeeInterface $employees) {
        $this->employees = $employees;
    }

    public function index() {
        try {
            $employees = [
                'employees' => $this->employees->getAll()
            ];
            return view('admin.employee.index', $employees);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('admin.employee.form');
    }

    public function store(EmployeeRequest $request)
    {
        try {
            $this->employees->create($request->all());
            Toastr::success('Employee added successfully!');
            return redirect()->route('employee.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $edit = [
                'edit' => $this->employees->findById($id)
            ];
            return view('admin.employee.form', $edit);
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->route('employee.index');
        }
    }

    public function update(EmployeeRequest $request, $id)
    {
        try {
            $employee = $this->employees->findById($id);
         
            $updated = $this->employees->update($id, $request->all());

            $employee->agreement_start_date = $request->agreement_start_date;
            $employee->agreement_end_date = $request->agreement_end_date;
            $employee->is_active = $request->has('is_active') ? 1 : 0;
            $employee->save();

            if ($updated) {
                Toastr::success('Employee updated successfully!');
            } else {
                Toastr::warning('No changes made.');
            }

            return redirect()->route('employee.index');
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
