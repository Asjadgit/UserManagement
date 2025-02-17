<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Plan;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    // Display a list of plans
    public function index(Request $req)
    {
        $plans = Plan::all();
        if($req->wantsJson()){
            return response()->json([
                'plans' => $plans,
            ]);
        }
        return view('superadmin.plan.index', compact('plans'));
    }

    // Show the create form
    public function create()
    {
        $currencies = Currency::all();
        return view('superadmin.plan.create', compact('currencies'));
    }

    // Store a new plan
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'frequency' => 'required|string|in:daily,week,month,year',
            'trial_days' => 'required|integer|min:0',
            'features' => 'nullable|array',
            'type' => 'required|string|in:subscription,one-time',
        ]);

        // dd($request->all());

        $plan = Plan::create([
            'name' => $request->name,
            'price' => $request->price,
            'currency' => $request->currency,
            'frequency' => $request->frequency,
            'trial_days' => $request->trial_days,
            // Ensuring boolean values
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_free' => $request->has('is_free') ? 1 : 0,
            'stripe_product_id' => $request->stripe_product_id ?? NULL,
            'features' => json_encode($request->features),
            'type' => $request->type,
        ]);

        if($request->wantsJson()){
            return response()->json([
                'message' => 'Plan Created Successfully!',
                'plan' => $plan,
            ]);
        }

        return redirect()->route('plans.index')->with('success', 'Plan created successfully!');
    }

    public function show(Request $req,$id)
    {
        $plan = Plan::find($id);

        if($req->wantsJson()){
            return response()->json([
                'message' => "{$plan->name} Details",
                'plan' =>$plan
            ]);
        }

        return view('superadmin.plan.show',compact('plan'));
    }

    public function edit(Request $req,$id)
    {
        $plan = Plan::find($id);
        $currencies = Currency::all();
        if($req->wantsJson()){
            return response()->json([
                'message' => "Edit {$plan->name}",
                'plan' =>$plan
            ]);
        }
        return view('superadmin.plan.edit',compact('plan','currencies'));
    }

    // update the plan
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'frequency' => 'required|string|in:daily,week,month,year',
            'trial_days' => 'required|integer|min:0',
            'features' => 'nullable|array',
            'type' => 'required|string|in:subscription,one-time',
        ]);

        // dd($request->all());

        $plan = Plan::find($id);

        $plan->update([
            'name' => $request->name,
            'price' => $request->price,
            'currency' => $request->currency,
            'frequency' => $request->frequency,
            'trial_days' => $request->trial_days,
            // Ensuring boolean values
            'is_featured' => $request->has('is_featured'),
            'is_free' => $request->has('is_free'),
            'stripe_product_id' => $request->stripe_product_id ?? NULL,
            'features' => json_encode($request->features),
            'type' => $request->type,
        ]);

        if($request->wantsJson()){
            return response()->json([
                'message' => 'Plan updated Successfully!',
                'plan' => $plan,
            ]);
        }

        return redirect()->route('plans.index')->with('success', 'Plan updated successfully!');
    }

    public function destroy(Request $req,$id)
    {
        $plan = Plan::find($id);
        $plan->delete();

        if($req->wantsJson()){
            return response()->json([
                'message' => 'Plan Deleted Successfully!',
            ]);
        }

        return redirect()->route('plans.index')->with('success','Plan Deleted Successfully!');
    }
}

