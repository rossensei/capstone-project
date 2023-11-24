<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DepartmentInventoryController extends Controller
{
    public function index(Department $department)
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
            // ->paginate(10)
            // ->through(fn($property) => [
            //     'id' => $property->id,
            //     'tag_no' => $property->tag_no,
            //     'name' => $property->name,
            //     'description' => $property->description,
            //     'date_acquired' => $property->date_acquired->format('F j, Y'),
            //     'status' => $property->status,
            // ]);
            
        $dept = Department::select('id', 'name', 'user_id', 'updated_at')
            ->with('user:id,name')
            ->find($department->id);

        $department = [
            'id' => $dept->id,
            'name' => $dept->name,
            'head' => $dept->user->name,
            'updated_at' => $dept->updated_at->format('F j, Y g:i A'),
        ];
        
        return inertia('Department/Inventory/Index', [
            'department' => $department,
            'properties' => $properties,
        ]);

    }

    public function create(Department $department)
    {
        return inertia('Department/Inventory/Create', [
            'department' => $department
        ]);
    }

    public function store(Department $department, Request $request)
    {
        $attr = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'date_acquired' => ['required', 'date'],
        ]);

        $department->properties()->create($attr);
        $department->touch();

        return back()->with('success', 'New item successfully added!');
    }

    public function update(Department $department, Property $property, Request $request)
    {


        $attr = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'date_acquired' => ['required', 'date'],
        ]);

        $property->update($attr);
        $department->touch();

        return back()->with('success', 'Property details has been updated.');
    }

    public function updateStatus(Department $department, Property $property, Request $request)
    {
        $property->update(['status' => $request->status]);
        $department->touch();

        return back()->with('success', 'Status for '. $property->name . ' has been updated.');
    }

    public function deleteProperty(Department $department, Property $property)
    {
        $property->delete();

        $department->touch();

        return back()->with('success', 'Property has been successfully removed from this department.');
    }
}
