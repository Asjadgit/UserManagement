<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Requests\PostRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'active'); // Default to 'active' if no status is selected

        $teams = Team::with(['manager', 'members'])
            ->where('status', $status)
            ->get();

        if ($request->wantsJson()) {
            return response()->json(['teams' => $teams]);
        }

        return view('superadmin.team.index', compact('teams', 'status'));
    }


    public function create()
    {
        $users = User::all();
        return view('superadmin.team.create', compact('users'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'manager_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'members' => 'required|array',
            'members.*' => 'exists:users,id',
        ]);

        $team = Team::create([
            'name' => $request->name,
            'manager_id' => $request->manager_id,
            'description' => $request->description,
            'status' => 'active',
        ]);

        $team->members()->attach($request->members);

        $team->with('members');

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Team created successfully', 'team' => $team]);
        }

        return redirect()->route('teams.index')->with('success', 'Team Created Successfully');
    }

    public function show(Request $request, $id)
    {
        $team = Team::with(['manager', 'members'])->find($id);

        if ($request->wantsJson()) {
            return response()->json(
                [
                    'message' => 'Team Details',
                    'team' => $team,
                ]

            );
        }

        return view('superadmin.team.show', compact('team'));
    }


    public function edit(Request $request, $id)
    {

        $team = Team::with(['manager', 'members'])->find($id);
        $users = User::all();

        if ($request->wantsJson()) {
            return response()->json(
                [
                    'message' => 'Team Details',
                    'team' => $team,
                ]

            );
        }

        return view('superadmin.team.edit', compact('team', 'users'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string',
            'manager_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'members' => 'required|array',
            'members.*' => 'exists:users,id',
        ]);

        $team = Team::find($id);

        $team->update([
            'name' => $request->name,
            'manager_id' => $request->manager_id,
            'description' => $request->description,
            'status' => 'active',
        ]);

        $team->members()->syncWithoutDetaching($request->members);

        $team->with('members');

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Team Updated successfully', 'team' => $team]);
        }

        return redirect()->route('teams.index')->with('success', 'Team Updated Successfully');
    }

    public function destroy(Request $request, $id)
    {
        $team = Team::where('id', $id)->where('status', 'inactive')->first();

        if (!$team) {
            return redirect()->route('teams.index')->with('error', 'Only inactive teams can be deleted!');
        }

        $team->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Team deleted successfully']);
        }

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully!');
    }

    public function toggleStatus(Request $request, $id)
    {
        $team = Team::find($id);

        if ($team) {
            // Toggle status
            $newStatus = $team->status === 'active' ? 'inactive' : 'active';

            $team->update([
                'status' => $newStatus,
            ]);

            $message = $newStatus === 'active' ? 'Team Reactivated Successfully!' : 'Team Deactivated Successfully!';
        } else {
            $message = 'Team not found!';
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('teams.index')->with('success', $message);
    }

}
