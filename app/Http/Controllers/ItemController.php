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
    public function index(Request $request)
    {
        $search = $request->search;
        $category = $request->category;
        $field = $request->field;
        $direction = $request->direction;
        $perPage = $request->perPage ?? 5;

        $query = Item::query();
        
        $query->with(['category:id,cat_name', 'unit:id,unit_name,abbreviation']);

        if($search) {
            $query->where('item_name', 'LIKE', "%{$search}%");
        }

        if($category) {
            $query->where('category_id', $category);
        }

        if($field && $direction) {
            $query->orderBy($field, $direction);
        }

        $items = $query->paginate($perPage)
            ->onEachSide(0)
            ->withQueryString()
            ->through(fn($item) => [
                'id' => $item->id,
                'item_name' => $item->item_name,
                'brand' => $item->brand,
                'color' => $item->color,
                'size' => $item->size,
                'qty_stock' => $item->qty_stock,
                'unit_abbreviation' => $item->unit->abbreviation,
                'category' => $item->category->cat_name,
            ]);

        $categories = Category::select('id', 'cat_name')->get();
        return inertia('Item/Index', [
            'categories' => $categories,
            'items' => $items,
            'filters' => $request->only(['search', 'perPage', 'category', 'field', 'direction'])
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'item_name' => ['required'],
            'category_id' => ['required'],
            'qty_stock' => ['required', 'numeric', 'min:0'],
            'unit_id' => ['required'],
        ],[
            'category_id.required' => 'The category field is required.',
            'unit_id.required' => 'The unit field is required.',
            'qty_stock.required' => 'The quantity stocks field is required.',
            'qty_stock.min' => 'The quantity stocks field must not contain a negative number.',
        ]);
        
        Item::create($request->all());

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
            'item_name' => ['required'],
            'category_id' => ['required'],
            'qty_stock' => ['required', 'numeric', 'min:0'],
            'unit_id' => ['required'],
        ],[
            'category_id.required' => 'The category field is required.',
            'unit_id.required' => 'The unit field is required.',
            'qty_stock.required' => 'The quantity stocks field is required.',
            'qty_stock.min' => 'The quantity stocks field must not contain a negative number.',
        ]);

        $item->update($request->all());

        return back()->with('success', 'Item details has been updated.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        if($item->transactionItem()->exists())
        {
            return back()->with('error', 'You cannot delete this item because it has existing transactions.');
        }
        $item->delete();

        return back()->with('success', 'Item has been removed from the inventory.');
    }
}
