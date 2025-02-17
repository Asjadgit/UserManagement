<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    // Display a listing of currencies
    public function index(Request $req)
    {
        $currencies = Currency::all();
        if ($req->wantsJson()) {
            return response()->json([
                'currencies' => $currencies,
            ]);
        }
        return view('superadmin.currency.index', compact('currencies'));
    }

    // Show the form for creating a new currency (Optional if using a modal)
    public function create()
    {
        return view('superadmin.currency.create');
    }

    // Store a newly created currency in storage
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'nullable|string',
            'currency' => 'nullable|string',
            'code' => 'nullable|string|max:10',
            'symbol' => 'nullable|string|max:10',
            'thousand_separator' => 'nullable|string|max:5',
            'decimal_separator' => 'nullable|string|max:5',
        ]);

        $currency = Currency::create($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => "Currency Created Successfully.",
                'currency' => $currency,
            ]);
        }

        return redirect()->route('currencies.index')->with('success', 'Currency added successfully.');
    }

    // Display the specified currency
    public function show(Request $req, $id)
    {
        $currency = Currency::findOrFail($id);
        if ($req->wantsJson()) {
            return response()->json([
                'message' => "{$currency->currency} Details",
                'currency' => $currency,
            ]);
        }
        return view('superadmin.currency.show', compact('currency'));
    }

    // Show the form for editing the specified currency
    public function edit(Request $req, $id)
    {
        $currency = Currency::findOrFail($id);

        if ($req->wantsJson()) {
            return response()->json([
                'message' => "Edit {$currency->currency} Details",
                'currency' => $currency,
            ]);
        }
        return view('superadmin.currency.edit', compact('currency'));
    }

    // Update the specified currency in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'country' => 'nullable|string',
            'currency' => 'nullable|string',
            'code' => 'nullable|string|max:10',
            'symbol' => 'nullable|string|max:10',
            'thousand_separator' => 'nullable|string|max:5',
            'decimal_separator' => 'nullable|string|max:5',
        ]);

        // dd($request->country);

        $currency = Currency::findOrFail($id);
        $currency->update($request->all());


        if ($request->wantsJson()) {
            return response()->json([
                'message' => "Currency Updated Successfully.",
                'currency' => $currency,
            ]);
        }

        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    // Remove the specified currency from storage
    public function destroy(Request $request,$id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => "Currency Deleted Successfully.",
            ]);
        }

        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
