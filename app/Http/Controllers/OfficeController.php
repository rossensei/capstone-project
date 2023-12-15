<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Office;
use App\Models\Transaction;
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

        if($search) {
            $query->where('office_name', 'LIKE', "%{$search}%");
        }

        if($dateFrom && $dateTo) {
            $query->whereBetween('date_added', [$dateFrom, $dateTo]);
        }

        if($request->field && $request->direction) {
            $query->orderBy($request->field, $request->direction);
        }

        $offices = $query->paginate($perPage)
            ->onEachSide(0)
            ->withQueryString()
            ->through(fn($office) => [
                'id' => $office->id,
                'office_name' => $office->office_name,
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
            'office_name' => ['required', 'string'],
        ]);

        $fields['date_added'] = Carbon::now()->format('Y-m-d');

        Office::create($fields);

        return back()->with('success', 'A new office has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        $personnelIds = $office->personnels->pluck('id');
        $officeTransactions = Transaction::whereIn('personnel_id', $personnelIds)
            ->with([
                'personnel:id,name,office_id',
                'personnel.office:id,office_name',
                ])
            ->withCount('transactionItems')
            ->get();

        return inertia('Office/Show', [
            'officeTransactions' => $officeTransactions,
            'office' => $office,
        ]);
    }

    public function transactionDetails(Office $office, Transaction $transaction)
    {
        // dd($office, $transaction);
        $transactionWithItems = $transaction->load([
            'personnel:id,name',
            'transactionItems:id,item_id,transaction_id,qty',
            'transactionItems.item:id,item_name,brand,color,size,qty_stock'
        ]);

        return inertia('Office/TransactionDetails', [
            'transaction' =>  $transactionWithItems,
            'office' => $office
        ]);
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
            'office_name' => ['required', 'string'],
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
        if($office->personnels()->exists()) {
            return back()->with('error', 'Delete request failed. This office has existing personnels.');
        } else {
            $office->delete();

            return back()->with('success', 'Office has been removed.');
        }
    }
}
