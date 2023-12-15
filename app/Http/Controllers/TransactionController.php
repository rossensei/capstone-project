<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Personnel;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::withCount('transactionItems')->with([
            'personnel:id,name'
            ])->latest()->get();

        return inertia('Transaction/Index', [
            'transactions' => $transactions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $personnels = Personnel::select('id', 'name')->orderBy('name')->get();

        $items = Item::select('id', 'item_name', 'qty_stock', 'category_id', 'unit_id')
            ->with([
                'category:id,cat_name',
                'unit:id,unit_name',
            ])
            ->where('qty_stock', '>', 0)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'item_name' => $item->item_name,
                    'qty_stock' => $item->qty_stock,
                    'category' => $item->category->cat_name,
                    'unit' => $item->unit->unit_name,
                ];
            });
            
        return inertia('Transaction/Create', [
            'personnels' => $personnels,
            'items' => $items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        if(!$request->personnel_id) {
            return back()->with('error', "You haven't selected a personnel.");
        }

        if(!$request['transaction_items']) {
            return back()->with('error', "You haven't selected an item.");
        }

        $transactionItems = $request['transaction_items'];

        foreach($transactionItems as $data) {
            
            if(!$data['item_id']) {
                return back()->with('error', "One or more added rows has no selected item.");
            }

            if(!$data['qty']) {
                return back()->with('error', 'One or more selected items has zero in quantity. Please add atleast 1.');
            }

            $item = Item::find($data['item_id']);

            if($item->qty_stock < $data['qty']) {
                return back()->with('error', "One or more selected items has lower stocks than the requested quantity.");
            }

            $item->qty_stock -= $data['qty'];

            $item->save();
        }

        $transaction = Transaction::create([
            'personnel_id' => $request->personnel_id,
            'remarks' => $request->remarks,
            'date_time' => now(),
        ]);

        $transaction->transactionItems()->createMany($transactionItems);


        return back()->with('success', 'Transaction has been recorded.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load([
            'personnel:id,name,office_id',
            'personnel.office:id,office_name',
            'transactionItems:id,transaction_id,item_id,qty',
            'transactionItems.item:id,item_name,brand,color,size'
        ]);

        return inertia('Transaction/Show', [
            'transaction' => $transaction
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {

        $personnels = Personnel::select('id', 'name')->orderBy('name')->get();

        $items = Item::select('id', 'item_name', 'qty_stock', 'category_id', 'unit_id')
            ->with([
                'category:id,cat_name',
                'unit:id,unit_name',
            ])
            ->where('qty_stock', '>', 0)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'item_name' => $item->item_name,
                    'qty_stock' => $item->qty_stock,
                    'category' => $item->category->cat_name,
                    'unit' => $item->unit->unit_name,
                ];
            });

        return inertia('Transaction/Edit', [
            'transaction' => $transaction->load('transactionItems'),
            'personnels' => $personnels,
            'items' => $items,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // dd(!$request->personnel_id);
        // Validation
        if(!$request->personnel_id) {
            return back()->with('error', "Error updating transaction details. You might haven not selected a personnel.");
        }

        $transaction->update([
            'personnel_id' => $request->personnel_id,
            'remarks' => $request->remarks,
        ]);

        return redirect('/transactions')->with('success', 'Transaction has been recorded.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->transactionItems()->delete();
        $transaction->delete();

        return back()->with('success', 'Transaction has been deleted.');
    }

    public function generatePdf(Request $request)
    {
        dd($request->all());
    }
}
