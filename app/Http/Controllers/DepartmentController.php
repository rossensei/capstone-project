<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
// use Carbon\Carbon;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $dateFrom = $request->from;
        $dateTo = $request->to;
        $search = $request->search;
        $perPage = $request->perPage ?? 5;

        $query = Department::query();

        $query->with('user');

        if($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if($dateFrom && $dateTo) {
            $query->whereBetween('date_added', [$dateFrom, $dateTo]);
        }

        if($request->field && $request->direction) {
            if($request->field === 'head') {
                $query->join('users', 'departments.user_id', '=', 'users.id')
                    ->orderBy('users.name', $request->direction);

                // dd($query->get())
            } else {
                // $query->with('user');

                $query->orderBy($request->field, $request->direction);
            }
            
        }

        // $query->with('user');

        $departments = $query->paginate($perPage)
            ->withQueryString()
            ->through(fn($department) => [
                'id' => $department->id,
                'name' => $department->name,
                'head' => $department->user->name,
                'date_added' => Carbon::parse($department->date_added)->format('F d, Y'),
                'properties_count' => $department->properties->count(),
            ]);
        
        return inertia('Department/Index', [
            'departments' => $departments,
            'filters' => $request->only(['search', 'perPage', 'from', 'to', 'field', 'direction']),
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

        $fields['date_added'] = Carbon::now()->toDateString();

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
        if($department->properties()->exists()) {
            // dd('This department has existing properties');
            return back()->with('error', 'Delete request failed. This department has existing properties.');
        } else {
            $department->delete();

            return back()->with('success', 'Department has been removed.');
        }
    }
}
