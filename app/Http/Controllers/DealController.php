<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\VisibilityLevel;
use Illuminate\Http\Request;
use App\Models\VisibilityGroup;
use App\Models\VisibilitySetting;

class DealController extends Controller
{
    public function index(Request $request)
    {
        $deals = Deal::with('visibilityAssignments.visibilitylevel')->get();
        if ($request->wantsJson()) {
            return response()->json([
                'leads' => $deals,
            ], 201);
        } else {
            return view('deals.index', compact('deals'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $visibilityLevels = VisibilityLevel::all();
        return view('deals.create',compact('visibilityLevels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'level_id' => 'required|exists:visibility_levels,id', // Ensure level_id exists
        ]);

        $deals = Deal::create(['name' => $request->name]);

        // Assign visibility level using morph relationship
        $deals->visibilityAssignments()->create([
            'visibility_level_id' => $request->level_id,
        ]);

        // Retrieve all permissions
        $deals = Deal::all();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'deals created successfully.',
                'deals' => $deals->load('visibilityAssignments.visibilitylevel'),
            ], 201);
        } else {
            return redirect()->route('deals.index')->with('success', 'deal Added Successfully');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $deals = Deal::with('visibilityAssignments.visibilitylevel')->findOrFail($id);
        $visibilityLevels = VisibilityLevel::all();

        if ($request->wantsJson()) {
            return response()->json([
                'deals' => $deals,
            ], 200);
        } else {
            return view('deals.edit', compact('deals', 'visibilityLevels'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'level_id' => 'required|exists:visibility_levels,id',
        ]);

        $deals = Deal::find($id);

        $deals->update(['name' => $request->name]);

        // Update or create visibility assignment
        $deals->visibilityAssignments()->updateOrCreate(
            ['items_id' => $deals->id, 'items_type' => Deal::class],
            ['visibility_level_id' => $request->level_id]
        );

        // Retrieve all permissions
        $deals = Deal::all();
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'leads updated successfully.',
                'deals' => $deals->load('visibilityAssignments.visibilitylevel'),
            ], 201);
        } else {
            return redirect()->route('deals.index')->with('success', 'deal updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {

        // First, update the guard to 'web' before deleting
        $deals = Deal::where('id', $id)->first();

        if (!$deals) {
            return response()->json([
                'error' => 'deals not found.'
            ], 404);
        }

        // Now safely delete the permission
        $deals->delete();

        // Return response based on request type
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'deals deleted successfully.',
            ], 201);
        } else {
            return redirect()->route('deals.index')->with('success', 'deals deleted successfully.');
        }
    }

    // Show assign group form
    public function assignGroupForm($dealid)
    {
        $deal = Deal::findOrFail($dealid);
        $visibilityGroups = VisibilityGroup::all(); // Get all groups

        return view('deals.assign_group', compact('deal', 'visibilityGroups'));
    }

    // Handle assignment
    public function assignGroup(Request $request, $dealid)
    {
        $request->validate([
            'visibility_group_id' => 'required|exists:visibility_groups,id',
        ]);

        $deal = Deal::find($dealid);
        // dd($lead);

        VisibilitySetting::updateOrCreate(
            ['user_id' => auth()->id(), 'item_type' => 'Deal', 'item_id' => $deal->id],
            ['visibility_group_id' => $request->visibility_group_id]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Deal assigned to group successfully.',
            ]);
        }

        return redirect()->route('deals.index')->with('success', 'Deals assigned to group successfully.');
    }
}
