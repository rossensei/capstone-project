<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Carbon;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with([
            'unit:id,name,abbreviation',
            'category:id,cat_name',
        ])->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'category' => $item->category->cat_name,
                'init_stocks' => $item->init_stocks,
                'curr_stocks' => $item->curr_stocks,
                'used' => $item->transactions->sum('pivot.qty'),
                'unit' => $item->unit->name,
                'created_at' => $item->created_at->format('F j, Y'),
                // 'transactions' => $item->transactions->map(function ($transaction) {
                //     return [
                //         'id' => $transaction->id,
                //         'user' => $transaction->user->name,
                //         'date_time' => $transaction->date_time,
                //         'remarks' => $transaction->remarks,
                //     ];
                // }),
            ];
        });
        // $items = $data->map(function ($item) {
        //     return [
        //         'id' => $item->id,
        //         'name' => $item->name,
        //         'category' => $item->category->cat_name,
        //         'qty_stock' => $item->qty_stock,
        //         'unit' => $item->unit->name,
        //         'expiry_date' => $item->expiry_date,
        //     ];
        // });

        // dd($items);
        // $totalQty = 0;
        // foreach ($items as $item) {
        //     $totalQty = $item->transactions->sum('pivot.qty');
        //     // Now, $totalQty contains the total sum of qty for this item.
        // }
        // $items->each(function ($item) {
        //     $item->used = $item->transactions->sum('pivot.qty');
        // });

        return inertia('Item/Index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('cat_name')
                    ->get()
                    ->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'cat_name' => $category->cat_name,
                        ];
                    });

        $units = Unit::orderBy('name')
                    ->get()
                    ->map(function ($unit) {
                        return [
                            'id' => $unit->id,
                            'name' => $unit->name,
                        ];
                    });
        
        return inertia('Item/Create', [
            'categories' => $categories,
            'units' => $units,
        ]);                    
    }

    public function createExisting()
    {
        $units = Unit::orderBy('name')
                    ->get()
                    ->map(function ($unit) {
                        return [
                            'id' => $unit->id,
                            'name' => $unit->name,
                        ];
                    });
        $items = Item::with('unit:id,name')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'unit' => $item->unit_id,
                        ];
                    });


        
        return inertia('Item/CreateExisting', [
            'items' => $items,
            'units' => $units,
        ]);  
    }

    public function storeToExisting(Item $item, Request $request) {
        // dd($item, $request->all());
        $request->validate([
            'qty' => ['required', 'numeric', 'min:0']
        ], [
            'qty.required' => 'The quantity field is required.',
            'qty.min' => 'The quantity field must not contain a negative number.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required'],
            'category_id' => ['required'],
            'curr_stocks' => ['required', 'numeric', 'min:0'],
            'unit_id' => ['required'],
        ],[
            'category_id.required' => 'The category field is required.',
            'unit_id.required' => 'The unit field is required.',
            'curr_stocks.required' => 'The quantity stocks field is required.',
            'curr_stocks.min' => 'The quantity stocks field must not contain a negative number.',
        ]);

        $attributes = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'init_stocks' => $request->curr_stocks,
            'curr_stocks' => $request->curr_stocks,
            'unit_id' => $request->unit_id,
        ];
        
        Item::create($attributes);

        return redirect('/items')->with('success', 'A new item has been added to the inventory.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = Category::orderBy('cat_name')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'cat_name' => $category->cat_name,
                    ];
                });

        $units = Unit::orderBy('name')
                ->get()
                ->map(function ($unit) {
                    return [
                        'id' => $unit->id,
                        'name' => $unit->name,
                    ];
                });

        return inertia('Item/Edit', [
            'categories' => $categories,
            'units' => $units,
            'item' => $item,
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => ['string', 'required'],
            'category_id' => ['required'],
            'curr_stocks' => ['required', 'numeric', 'min:0'],
            'unit_id' => ['required'],
        ],[
            'category_id.required' => 'The category field is required.',
            'unit_id.required' => 'The unit field is required.',
            'curr_stocks.required' => 'The quantity stocks field is required.',
            'curr_stocks.min' => 'The quantity stocks field must not contain a negative number.',
        ]);

        $attributes = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'init_stocks' => $request->curr_stocks,
            'curr_stocks' => $request->curr_stocks,
            'unit_id' => $request->unit_id,
        ];

        $item->update($attributes);

        return redirect('/items')->with('success', 'Item has been updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        // dd($item->transactions()->exists());

        if($item->transactions()->exists())
        {
            return back()->with('error', 'You cannot delete this item because it has existing transactions.');
        }
        $item->delete();

        return back()->with('success', 'Item has been removed from the inventory.');
    }

    public function bulkDelete(Request $request)
    {
        
        $ids = $request->input('ids');

        if($ids) {
            Item::whereIn('id', $ids)->delete();
            return back()->with('success', 'Items has been deleted.');
        }else {
            return back()->with('error', 'There was a problem processing your request.');
        }

    }
}
