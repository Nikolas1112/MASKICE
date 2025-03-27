<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource with an optional date filter.
     */
    public function index(Request $request)
    {
        $query = Employee::query();

        // Filter by a specific date (using the created_at field)
        if ($request->filled('date')) {
            $date = Carbon::parse($request->date)->toDateString();
            $query->whereDate('created_at', $date);
        }

        $salaries = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.salaries.index', compact('salaries'));
    }

    /**
     * Show the form for creating a new salary record.
     */
    public function create()
    {
        // Return a view to create a new salary record.
        // You can implement this view as needed.
        return view('admin.salaries.create');
    }

    /**
     * Store a newly created salary record in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'net_salary'   => 'required|numeric',
            'gross_salary' => 'required|numeric',
            'bonus'        => 'nullable|numeric',
            // Add additional fields as required.
        ]);

        // Create a new salary record
        Employee::create($validated);

        return redirect()->route('salaries.index')->with('success', 'Salary record created successfully.');
    }

    /**
     * Display the specified salary record.
     */
    public function show($id)
    {
        $salary = Employee::findOrFail($id);
        return view('admin.salaries.show', compact('salary'));
    }

    /**
     * Show the form for editing the specified salary record.
     */
    public function edit($id)
    {
        $salary = Employee::findOrFail($id);
        return view('admin.salaries.edit', compact('salary'));
    }

    /**
     * Update the specified salary record in storage.
     */
    public function update(Request $request, $id)
    {
        $salary = Employee::findOrFail($id);

        $validated = $request->validate([
            'net_salary'   => 'required|numeric',
            'gross_salary' => 'required|numeric',
            'bonus'        => 'nullable|numeric',
            // Validate other fields as necessary.
        ]);

        $salary->update($validated);

        return redirect()->route('salaries.index')->with('success', 'Salary record updated successfully.');
    }

    /**
     * Remove the specified salary record from storage.
     */
    public function destroy($id)
    {
        $salary = Employee::findOrFail($id);
        $salary->delete();

        return redirect()->route('salaries.index')->with('success', 'Salary record deleted successfully.');
    }
}
