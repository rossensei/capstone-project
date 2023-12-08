<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Category;

class ItemApiController extends Controller
{
    public function getUnits()
    {
        $units = Unit::select('id', 'unit_name')->get();

        return response()->json($units);
    }

    public function getCategories()
    {
        $categories = Category::select('id', 'cat_name')->get();

        return response()->json($categories);
    }

    public function getItems()
    {
        $items = Item::with('unit:id,name')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'unit' => $item->unit_id,
                        ];
                    });
                    
        return response()->json($items);
    }

    public function getItem(Item $item)
    {
        $data = $item->only(['id', 'unit_id', 'category_id', 'item_name', 'init_stocks', 'curr_stocks']);
        return response()->json($data);
    }
}
