<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Unit/Index', [
            'units' => Unit::select('id', 'unit_name', 'abbreviation', 'created_at')->paginate(5)->onEachSide(0),
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
        $attr = $request->validate([
            'unit_name' => ['required', 'string', 'unique:units'],
            'abbreviation' => ['required', 'string', 'unique:units']
        ]);

        Unit::create($attr);

        return back()->with('success', 'New quantity unit has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $attr = $request->validate([
            'unit_name' => ['required', 'string', Rule::unique(Unit::class)->ignore($unit->id)],
            'abbreviation' => ['required', 'string', Rule::unique(Unit::class)->ignore($unit->id)]
        ]);

        $unit->update($attr);

        return back()->with('success', 'Unit details has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        if($unit->items()->exists()) {
            return back()->with('error', 'Deletion has failed. This unit has existing items.');
        } else {
            $unit->delete();

            return back()->with('success', 'Unit has been deleted.');
        }
    }
}
