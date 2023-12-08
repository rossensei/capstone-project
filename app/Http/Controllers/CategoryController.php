<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('items')->paginate(5)->onEachSide(0);

        return inertia('Category/Index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cat_name' => ['required', 'string', 'unique:categories']
        ],[
            'cat_name.required' => 'The category name field is required.'
        ]);

        Category::create(['cat_name' => $request->cat_name]);

        return back()->with('success', 'A new category has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'cat_name' => ['required', 'string', Rule::unique(Category::class)->ignore($category->id)]
        ], [
            'cat_name.required' => 'The category name field is required.'
        ]);

        $category->update(['cat_name' => $request->cat_name]);

        return back()->with('success', 'Category has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->items()->exists()) {
            return back()->with('error', 'Deletion has failed. This category has existing items.');
        } else {
            $category->delete();

            return back()->with('success', 'Category has been deleted.');
        }
    }
}
