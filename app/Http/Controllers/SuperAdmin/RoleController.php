<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $roles = Role::all();
        if ($req->wantsJson()) {
            return response()->json([
                'roles' => $roles->load('permissions'),  // Return all roles with assigned permissions
            ], 201);
        } else {
            return view('superadmin.roles.index', compact('roles'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        $permissions = Permission::all();
        if ($req->wantsJson()) {
            return response()->json([
                'permissions' => $permissions
            ], 201);
        } else {
            return view('superadmin.roles.create', compact('permissions'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();
            $role->syncPermissions($permissions);
        }


        // Retrieve all roles with their permissions
        $roles = Role::with('permissions')->get();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Role created successfully.',
                'role' => $role->load('permissions'), // Return the created role with permissions
                'roles' => $roles // Return all roles with assigned permissions
            ], 201);
        } else {
            return redirect()->route('roles.index')->with('success', 'Role created successfully.');
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
        $role = Role::find($id);
        $permissions = Permission::all();
        if ($request->wantsJson()) {
            return response()->json([
                'role' => $role,
                'permission' => $permissions,
            ], 200);
        } else {
            return view('superadmin.roles.edit', compact('role', 'permissions'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->update(['name' => $request->name]);
        $permissions = null;
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();
            $role->syncPermissions($permissions);
        }
        if ($request->wantsJson()) {
            return response()->json([
                'role' => $role,
                'permission' => $permissions,
            ], 200);
        } else {
            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        auth()->shouldUse('sanctum'); // Ensure correct guard is used
        $role = Role::where('id', $id)->first();

        if (!$role) {
            return response()->json([
                'error' => 'Permission not found.'
            ], 404);
        }

        // Update guard_name to 'web'
        $role->update(['guard_name' => 'web']);

        // Detach permissions before deleting the role
        $role->permissions()->detach();

        // Now delete the role
        $role->delete();

        $roles = Role::with('permissions')->get();
        if ($request->wantsJson()) {
            return response()->json([
                'role' => $roles,
            ], 200);
        } else {
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        }
    }
}
