<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::all();
        if ($request->wantsJson()) {
            return response()->json([
                'permission' => $permissions,
            ], 201);
        } else {
            return view('superadmin.permissions.index', compact('permissions'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $request->name]);

        // Retrieve all permissions
        $permissions = Permission::all();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Permission created successfully.',
                'permission' => $permissions,
            ], 201);
        } else {
            return redirect()->route('permissions.index')->with('success', 'Permission Added Successfully');
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
        $permission = Permission::find($id);
        if ($request->wantsJson()) {
            return response()->json([
                'permission' => $permission,
            ], 200);
        } else {
            return view('superadmin.permissions.edit', compact('permission'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        $permission = Permission::find($id);

        $permission->update(['name' => $request->name]);

        // Retrieve all permissions
        $permissions = Permission::all();
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Permission updated successfully.',
                'permission' => $permissions,
            ], 201);
        } else {
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {

            // First, update the guard to 'web' before deleting
            $permission = Permission::where('id', $id)->first();

            if (!$permission) {
                return response()->json([
                    'error' => 'Permission not found.'
                ], 404);
            }

            // Update guard_name to 'web'
            $permission->update(['guard_name' => 'web']);

            // Detach roles before deleting (important for Spatie package)
            $permission->roles()->detach();

            // Now safely delete the permission
            $permission->delete();
            // if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Permission deleted successfully.',
            ], 201);
            // } else {
            //     return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
            // }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function deletePermission($id, Request $request)
    {
        auth()->shouldUse('sanctum'); // Ensure correct guard is used

        // First, update the guard to 'web' before deleting
        $permission = Permission::where('id', $id)->first();

        if (!$permission) {
            return response()->json([
                'error' => 'Permission not found.'
            ], 404);
        }

        // Update guard_name to 'web'
        $permission->update(['guard_name' => 'web']);

        // Detach roles before deleting (important for Spatie package)
        $permission->roles()->detach();

        // Now safely delete the permission
        $permission->delete();

        // Return response based on request type
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Permission deleted successfully.',
            ], 201);
        } else {
            return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
        }
    }
}
