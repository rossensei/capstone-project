<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Venue;
use App\Models\Office;
use App\Models\Category;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{

    public function index()
    {
        $items = Item::select('id', 'item_name')->orderBy('item_name', 'asc')->get();
        $categories = Category::select('id', 'cat_name')->orderBy('cat_name', 'asc')->get();
        $units = Unit::select('id', 'unit_name', 'abbreviation')->get();
        $venues = Venue::select('id', 'venue_name', 'building')->get();

        return inertia('Purchase/Index', [
            'items' => $items,
            'categories' => $categories,
            'units' => $units,
            'venues' => $venues,
        ]);
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'item_name' => ['string', 'required'],
            'category_id' => ['required'],
            'qty_stock' => ['required', 'numeric', 'min:1'],
            'unit_id' => ['required'],
        ],[
            'category_id.required' => 'The category field is required.',
            'unit_id.required' => 'Please specify a unit of quantity.',
            'qty_stock.required' => 'The quantity stock is required.',
        ]);
        
        Item::create($request->all());

        return back()->with('success', 'Item has been added to the inventory!');
    }

    public function replenish(Request $request)
    {
        $request->validate([
            'quantity' => ['required', 'numeric', 'min:0'],
            'itemId' => ['required'],
        ], [
            'itemId.required' => 'Please select an item.'
        ]);

        $item = Item::find($request->itemId);

        $item->qty_stock += $request->quantity;

        $item->save();

        return back()->with('success', 'Stocks for '. $item->item_name . ' has been replenished.');
    }

    public function storeProperty(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required'],
            'venue_id' => ['required'],
            'tag_no' => ['required', 'string', 'unique:properties'],
        ],[
            'venue_id.required' => 'You must select a venue.',
        ]);

        $attr = $request->all();

        $attr['date_acquired'] = Carbon::now()->format('Y-m-d');

        Property::create($attr);

        return back()->with('success', 'New purchased property has been added.');
    }
}
