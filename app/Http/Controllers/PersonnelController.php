<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Personnel;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $office = $request->office;
        $perPage = $request->perPage ?? 5;

        $query = Personnel::select('id', 'name', 'office_id')->with('office:id,office_name');

        // $query->;

        if($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if($office) {
            $query->where('office_id', $office);
        }

        $personnels = $query->paginate($perPage)
            ->onEachSide(0)
            ->through(fn($personnel) => [
                'id' => $personnel->id,
                'name' => $personnel->name,
                'office' => $personnel->office->office_name,
            ]);

        $offices = Office::select('id', 'office_name')
            ->orderBy('office_name', 'asc')
            ->get();

        return inertia('Personnel/Index', [
            'personnels' => $personnels,
            'offices' => $offices,
            'filters' => $request->only(['search', 'perPage', 'office'])
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
            'name' => ['string', 'required'],
            'office_id' => ['required'],
        ], [
            'office_id.required' => 'You must select an office.',
        ]);

        // dd($attr);

        Personnel::create($attr);

        return back()->with('success', 'You have added a new personnel');
    }

    /**
     * Display the specified resource.
     */
    public function show(Personnel $personnel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personnel $personnel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Personnel $personnel)
    {
        $attr = $request->validate([
            'name' => ['string', 'required'],
            'office_id' => ['required'],
        ], [
            'office_id.required' => 'You must select an office.',
        ]);

        $personnel->update($attr);

        return back()->with('success', 'Personnel details has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personnel $personnel)
    {
        // if($personnel->has)
        // dd();
        if($personnel->transactions()->exists()) {
            return back()->with('error', "Personnel cannot be deleted. This personnel has exisiting transactions.");
        }

        $personnel->delete();

        return back()->with('success', 'Personnel has been deleted successfully!');
    }
}
