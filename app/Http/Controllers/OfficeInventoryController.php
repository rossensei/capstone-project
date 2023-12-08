<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Property;
use Illuminate\Http\Request;

class OfficeInventoryController extends Controller
{
    public function index(Office $office, Request $request)
    {

        $search = $request->search;
        $per_page = $request->perPage ?? 5;
        $field = $request->field;
        $direction = $request->direction;
        $status = $request->status;

        $transactions = $office->personnels()->with(['transactions.items'])->get();
        //fetches all the properties of an office as a collection
        $query = $office->properties(); 

        if($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('tag_no', 'like', "%{$search}%");
            });
        }

        if($field && $direction) {
            $query->orderBy($field, $direction);
        }

        if($status) {
            $query->where('status', $status);
        }

        $properties = $query->paginate($per_page)
            ->onEachSide(0)
            ->withQueryString()
            ->through(fn($property) => [
                'id' => $property->id,
                'tag_no' => $property->tag_no,
                'name' => $property->name,
                'description' => $property->description,
                'date_acquired' => $property->date_acquired->format('F j, Y'),
                'status' => $property->status,
            ]);
            
        $ofc = Office::select('id', 'office_name', 'user_id', 'updated_at')
            ->with('user:id,name')
            ->find($office->id);

        $office = [
            'id' => $ofc->id,
            'name' => $ofc->office_name,
            'head' => $ofc->user->name,
        ];

        
        return inertia('Office/Inventory/Index', [
            'office' => $office,
            'properties' => $properties,
            'transactions' => $transactions,
            'filters' => $request->only(['search', 'perPage', 'field', 'direction', 'status'])
        ]);

    }

    public function store(Office $office, Request $request)
    {
        $attr = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'date_acquired' => ['required', 'date'],
            'qty' => ['required', 'numeric', 'min:1'],
        ]);

        if($request->qty > 1) {

            $propertiesArray = [];

            for($i=1; $i <= $request->qty; $i++) {
                $propertiesArray[] = [
                    'name' => $request->name,
                    'description' => $request->description,
                    'date_acquired' => $request->date_acquired,
                ];
            }

            $office->properties()->createMany($propertiesArray);

        } else {

            unset($attr['qty']);

            $office->properties()->create($attr);
        }

        // $office->touch();

        return back()->with('success', 'New item successfully added!');
    }

    public function update(Office $office, Property $property, Request $request)
    {


        $attr = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'date_acquired' => ['required', 'date'],
        ]);

        $property->update($attr);
        // $department->touch();

        return back()->with('success', 'Property details has been updated.');
    }

    public function updateStatus(Office $office, Property $property, Request $request)
    {
        $property->update(['status' => $request->status]);
        return back()->with('success', 'Status for '. $property->name . ' has been updated.');
    }

    public function deleteProperty(Office $office, Property $property)
    {
        $property->delete();
        return back()->with('success', 'Property has been successfully removed from this department.');
    }
}
