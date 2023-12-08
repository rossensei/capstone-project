<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Property;
use App\Models\Office;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{

    public function index()
    {
        $items = Item::select('id', 'item_name')->get();
        $categories = Category::select('id', 'cat_name')->orderBy('cat_name', 'asc')->get();
        $units = Unit::select('id', 'unit_name', 'abbreviation')->get();
        $offices = Office::select('id', 'office_name')->get();

        return inertia('Purchase/Index', [
            'items' => $items,
            'categories' => $categories,
            'units' => $units,
            'offices' => $offices,
        ]);
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'item_name' => ['string', 'required'],
            'category_id' => ['required'],
            'init_stocks' => ['required', 'numeric', 'min:0'],
            'unit_id' => ['required'],
        ],[
            'category_id.required' => 'The category field is required.',
            'unit_id.required' => 'Please specify a unit of quantity.',
            'init_stocks.required' => 'The quantity stock is required.',
        ]);

        $attributes = [
            'item_name' => $request->item_name,
            'category_id' => $request->category_id,
            'init_stocks' => $request->init_stocks,
            'curr_stocks' => $request->init_stocks,
            'unit_id' => $request->unit_id,
            'expiry_date' => $request->expiry_date,
        ];
        
        Item::create($attributes);

        return back()->with('success', 'Item has been added to the inventory!');
    }

    public function addToExistingItem(Item $item, Request $request)
    {
        $request->validate([
            'qty' => ['required', 'numeric', 'min:0']
        ]);

        $newStock = $item->curr_stocks + $request->qty;


        $item->update([
            'init_stocks' => $newStock,
            'curr_stocks' => $newStock,
        ]);

        return back()->with('success', 'Stocks for '. $item->item_name . ' has been replenished.');
    }

    public function storeProperty(Request $request)
    {
        // dd($request->all());
        $attr = $request->validate([
            'name' => ['string', 'required'],
            'office_id' => ['required'],
            'description' => ['string', 'nullable'],
            'date_acquired' => ['required', 'date'],
            'qty' => ['required', 'numeric', 'min:1'],
        ],[
            'department_id.required' => 'The department field is required.',
            'date_acquired.required' => 'The acquisition date field is required.',
        ]);


        $qty = $attr['qty'];
        unset($attr['qty']);

        if($qty > 1) {
            for($i=1; $i <= $qty; $i++) {
                Property::create($attr);
            }

            return back()->with('success', 'Property has been added to inventory.');
        }


        $property = Property::create($attr);
        
        $office = $property->office->office_name;

        return back()->with('success', 'Property has been added to '.$office. ' inventory.');
    }
}
