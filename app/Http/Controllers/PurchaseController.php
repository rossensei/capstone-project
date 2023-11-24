<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Property;
use App\Models\Department;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PurchaseController extends Controller
{
    public function itemForm() 
    {
        $categories = Category::select('id', 'cat_name')->get();
        $units = Unit::select('id', 'name', 'abbreviation')->get();
        return inertia('Purchase/ItemForm', [
            'categories' => $categories,
            'units' => $units,
        ]);
    }

    public function propertyForm() 
    {
        $categories = Category::select('id', 'cat_name')->get();
        $departments = Department::orderBy('name')->select('id', 'name')->get();

        return inertia('Purchase/PropertyForm', [
            'categories' => $categories,
            'departments' => $departments,
        ]);
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required'],
            'category_id' => ['required'],
            'qty' => ['required', 'numeric'],
            'unit_id' => ['required'],
        ],[
            'category_id.required' => 'The category field is required.',
            'unit_id.required' => 'Please specify a unit of quantity.',
            'qty.required' => 'The quantity stock is required.',
        ]);

        $attributes = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'qty' => $request->qty,
            'unit_id' => $request->unit_id,
            'expiry_date' => $request->expiry_date,
        ];
        
        Item::create($attributes);

        return back()->with('success', 'Item has been added to the inventory!');
    }

    public function storeProperty(Request $request)
    {
        // dd($request->all());
        $attributes = $request->validate([
            'name' => ['string', 'required'],
            'category_id' => ['required'],
            'department_id' => ['required'],
            'description' => ['string', 'nullable'],
            'date_acquired' => ['required', 'date'],
        ],[
            'category_id.required' => 'The category field is required.',
            'department_id.required' => 'The department field is required.',
            'date_acquired.required' => 'The acquisition date field is required.',
        ]);



        // dd($id);

        // $attributes = [
        //     'name' => $request->name,
        //     'category_id' => $request->category_id,
        //     'department_id' => $request->department_id,
        //     'description' => $request->description,
        //     'date_acquired' => $request->date_acquired,
        // ];

        Property::create($attributes);

        return back()->with('success', 'Property has been added to inventory.');
    }
}
