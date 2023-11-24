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
        $units = Unit::select('id', 'name')->get();

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
        // $items = Item::with('unit:id,name')
        //             ->get()
        //             ->map(function ($item) {
        //                 return [
        //                     'id' => $item->id,
        //                     'name' => $item->name,
        //                     'unit' => $item->unit_id,
        //                 ];
        //             });

        return response()->json($item);
    }
}
