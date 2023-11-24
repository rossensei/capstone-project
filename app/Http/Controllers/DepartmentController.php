<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $dept = Department::query()

            ->with('user')
            // ->orderBy('name')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($department) => [
                'id' => $department->id,
                'name' => $department->name,
                'head' => $department->user->name,
                'date_added' => $department->created_at->format('F j, Y'),
                'properties_count' => $department->properties->count(),
            ]);
        
        return inertia('Department/Index', [
            'departments' => $dept,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Department/Create', [
            'users' => User::orderBy('name')->select('id', 'name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'string', 'unique:departments'],
            'user_id' => ['required']
        ],[
            'user_id.required' => 'The department head must not be empty.',
            'name.unique' => 'Department name already exist.'
        ]);

        Department::create($fields);

        return redirect('/departments')->with('success', 'A new department has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $properties = Property::where('department_id', $department->id)
            ->get()
            ->map(function($property) {
                return [
                    'id' => $property->id,
                    'tag_no' => $property->tag_no,
                    'name' => $property->name,
                    'description' => $property->description,
                    'date_acquired' => $property->date_acquired->format('F j, Y'),
                    'status' => $property->status,
                ];
            });

        $dept = Department::select('id', 'name', 'user_id', 'updated_at')
            ->with('user:id,name')
            ->find($department->id);

        $department = [
            'id' => $dept->id,
            'name' => $dept->name,
            'head' => $dept->user->name,
            'updated_at' => $dept->updated_at->format('F j, Y g:i A'),
        ];

        return inertia('Department/Show', [
           'department' => $department,
           'properties' => $properties
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return inertia('Department/Edit', [
            'department' => $department,
            'users' => User::orderBy('name')->select('id', 'name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $fields = $request->validate([
            'name' => ['required', 'string', Rule::unique('departments')->ignore($department->id)],
            'user_id' => ['required']
        ],[
            'user_id.required' => 'The department head must not be empty.',
            'name.unique' => 'Department name already exists'
        ]);

        $dept = $department->name;

        $department->update($fields);

        return redirect('/departments')->with('success', $dept.' has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
