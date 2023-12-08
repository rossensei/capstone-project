<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dateFrom = $request->from;
        $dateTo = $request->to;
        $search = $request->search;
        $perPage = $request->perPage ?? 5;

        $query = Office::query();

        $query->with('user');

        if($search) {
            $query->where('office_name', 'like', "%{$search}%");
        }

        if($dateFrom && $dateTo) {
            $query->whereBetween('date_added', [$dateFrom, $dateTo]);
        }

        if($request->field && $request->direction) {
            if($request->field === 'head') {
                $query->join('users', 'offices.user_id', '=', 'users.id')
                ->select('offices.*', 'users.name as head_name') // Alias the 'name' column
                ->orderBy('head_name', $request->direction);
            } else {
                $query->orderBy($request->field, $request->direction);
            }
            
        }

        $offices = $query->paginate($perPage)
            ->onEachSide(0)
            ->withQueryString()
            ->through(fn($office) => [
                'id' => $office->id,
                'office_name' => $office->office_name,
                'head' => $office->user->name,
                'date_added' => $office->date_added,
            ]);
        
        return inertia('Office/Index', [
            'offices' => $offices,
            'filters' => $request->only(['search', 'perPage', 'from', 'to', 'field', 'direction']),
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
        $fields = $request->validate([
            'office_name' => ['required', 'string', 'unique:offices'],
            'user_id' => ['required']
        ],[
            'user_id.required' => 'The office head must not be empty.',
            'office_name.unique' => 'Office name already exist.'
        ]);

        $fields['date_added'] = Carbon::now()->toDateString();

        Office::create($fields);

        return back()->with('success', 'A new office has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Office $office)
    {
        $fields = $request->validate([
            'office_name' => ['required', 'string', Rule::unique(Office::class)->ignore($office->id)],
            'user_id' => ['required']
        ],[
            'user_id.required' => 'The office head must not be empty.',
            'office_name.unique' => 'Office name already exist.'
        ]);

        $office_name = $office->office_name;

        $office->update($fields);

        return back()->with('success', $office_name.' has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        if($office->properties()->exists()) {
            return back()->with('error', 'Delete request failed. This office has existing properties.');
        } else {
            $office->delete();

            return back()->with('success', 'Office has been removed.');
        }
    }
}
