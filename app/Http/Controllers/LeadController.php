<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\VisibilityLevel;
use Illuminate\Http\Request;
use App\Models\VisibilityGroup;
use App\Models\VisibilitySetting;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        // $leads = Lead::with('visibilityAssignments.visibilitylevel')->get();
        $leads = Lead::with('visibilityAssignments.visibilitylevel')->get();
        // dd($leads);

        if ($request->wantsJson()) {
            return response()->json([
                'leads' => $leads,
            ], 201);
        } else {
            return view('leads.index', compact('leads'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $visibilityLevels = VisibilityLevel::all();
        return view('leads.create', compact('visibilityLevels'));
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

        // Create the lead
        $lead = Lead::create(['name' => $request->name]);

        // Assign visibility level using morph relationship
        $lead->visibilityAssignments()->create([
            'visibility_level_id' => $request->level_id,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Lead created successfully.',
                'lead' => $lead->load('visibilityAssignments.visibilitylevel'), // Load visibility level
            ], 201);
        } else {
            return redirect()->route('leads.index')->with('success', 'Lead Added Successfully');
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
        $lead = Lead::with('visibilityAssignments.visibilitylevel')->findOrFail($id);
        $visibilityLevels = VisibilityLevel::all();

        if ($request->wantsJson()) {
            return response()->json([
                'lead' => $lead,
                'visibilityLevels' => $visibilityLevels,
            ], 200);
        } else {
            return view('leads.edit', compact('lead', 'visibilityLevels'));
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

        $lead = Lead::findOrFail($id);
        $lead->update(['name' => $request->name]);

        // Update or create visibility assignment
        $lead->visibilityAssignments()->updateOrCreate(
            ['items_id' => $lead->id, 'items_type' => Lead::class],
            ['visibility_level_id' => $request->level_id]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Lead updated successfully.',
                'lead' => $lead->load('visibilityAssignments.visibilitylevel'),
            ], 200);
        } else {
            return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {

        // First, update the guard to 'web' before deleting
        $leads = lead::where('id', $id)->first();

        if (!$leads) {
            return response()->json([
                'error' => 'leads not found.'
            ], 404);
        }

        // Now safely delete the permission
        $leads->delete();

        // Return response based on request type
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'leads deleted successfully.',
            ], 201);
        } else {
            return redirect()->route('leads.index')->with('success', 'leads deleted successfully.');
        }
    }


    // Show assign group form
    public function assignGroupForm($leadId)
    {
        $lead = Lead::findOrFail($leadId);
        $visibilityGroups = VisibilityGroup::all(); // Get all groups

        return view('leads.assign_group', compact('lead', 'visibilityGroups'));
    }

    // Handle assignment
    public function assignGroup(Request $request, $leadId)
    {
        $request->validate([
            'visibility_group_id' => 'required|exists:visibility_groups,id',
        ]);

        $lead = Lead::find($leadId);
        // dd($lead);

        VisibilitySetting::updateOrCreate(
            ['user_id' => auth()->id(), 'item_type' => 'Lead', 'item_id' => $lead->id],
            ['visibility_group_id' => $request->visibility_group_id]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Lead assigned to group successfully.',
            ]);
        }

        return redirect()->route('leads.index')->with('success', 'Lead assigned to group successfully.');
    }
}
