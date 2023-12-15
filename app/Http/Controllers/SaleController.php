<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('item:id,item_name,size')->paginate(10)->onEachSide(0);

        return inertia('Sale/Index', [
            'sales' => $sales
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => ['required'],
            'date_sold' => ['required', 'date'],
            'qty' => ['required'],
        ]);

        $item = Item::find($request->item_id);
        $item->qty_stock -= $request->qty;
        $item->save();

        Sale::create($request->all());

        return back()->with('success', 'Sale has been created. The quantity for the item has been deducted.');
    }

    public function destroy(Sale $sale) {
        $sale->delete();

        return back()->with('success', "Sale has been deleted.");
    }

    // public function update(Request $request, Sale $sale)
    // {
    //     $request->validate([
    //         'item_id' => ['required'],
    //         'date_sold' => ['required', 'date'],
    //     ]);

    //     $sale->update($request->all());

    //     return back()->with('success', 'Sale details has been updated.');
    // }
}
