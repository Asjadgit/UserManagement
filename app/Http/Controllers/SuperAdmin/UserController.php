<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Requests\LoginRequest;
use App\Models\UserMeta;
use Log;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // All these gates are defined in the AuthServiceProvider in the app/Providers directory

    public function index(Request $request)
    {
        $users = User::with(['roles.permissions', 'meta'])->get(); // Eager load roles and permissions

        // Check if the request expects JSON
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Users retrieved successfully.',
                'users' => $users
            ], 200);
        } else {
            // Return the Blade view for non-JSON requests
            return view('superadmin.users.index', compact('users'));
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        // Check if the user is allowed to create users
        if (!Gate::allows('create-user')) {
            if ($req->wantsJson()) {
                return response()->json(['error' => 'You do not have permission to create new user.'], 403);
            }

            return abort(403, 'You are unauthorized for this task.');
        }

        return view('superadmin.users.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if the user is allowed to create users
        if (!Gate::allows('create-user')) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'You do not have permission to create new user.'], 403);
            }

            return abort(403, 'You are unauthorized for this task.');
        }
        try {
            if (!auth()->check()) {
                Log::error('Unauthorized Access Attempt');
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'nullable|string|exists:roles,name',
                'permissions' => 'nullable|array',
                'permissions.*' => 'string|exists:permissions,name',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Store Meta fields using setMeta() method
            if (!empty($validated['phone'])) {
                $user->setMeta('phone', $validated['phone']);
            }
            if (!empty($validated['address'])) {
                $user->setMeta('address', $validated['address']);
            }


            $user->load('meta');

            Log::info('User created successfully', ['user' => $user]);

            // Assign Role
            // $user->assignRole($request->role);
            // Log::info('Role assigned successfully', ['role' => $request->role]);

            // Assign Permissions (if provided)
            // if ($request->has('permissions')) {
            //     $role = Role::where('name', $request->role)->first();
            //     if ($role) {
            //         $role->givePermissionTo($request->permissions);
            //         Log::info('Permissions assigned successfully', ['permissions' => $request->permissions]);
            //     } else {
            //         Log::error('Role not found for permission assignment', ['role' => $request->role]);
            //     }
            // }

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'User created successfully',
                    'user' => $user
                ], 201);
            } else {
                return redirect()->route('users.index')->with('success', 'User Created Successfully');
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        if (!Gate::allows('view-user')) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'You do not have permission to view this user.'], 403);
            }
            return abort(403, 'You are unauthorized for this task.');
        }


        $user = User::with(['roles.permissions', 'meta'])->findOrFail($id);
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'User Details',
                'user' => $user
            ], 201);
        }
        return view('superadmin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $req, string $id)
    {
        if (!Gate::allows('edit-user')) {
            return abort(403, 'You are Unauthorized for this task.');
        }

        $user = User::with(['roles.permissions', 'meta'])->findOrFail($id);

        // Convert meta collection into key-value pairs
        $metaData = $user->meta->pluck('meta_value', 'meta_key')->toArray();
        $user->phone = $metaData['phone'] ?? null;
        $user->address = $metaData['address'] ?? null;

        if ($req->wantsJson()) {
            return response()->json(['user' => $user], 200);
        } else {
            return view('superadmin.users.edit', compact('user'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if (!auth()->check()) {
                Log::error('Unauthorized Access Attempt');
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'role' => 'nullable|string|exists:roles,name',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
            ]);

            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update Meta Fields Using setMeta()
            $metaFields = ['phone', 'address'];

            foreach ($metaFields as $key) {
                if ($request->filled($key)) {  // Ensure field has a value
                    $user->setMeta($key, $request->$key);
                }
            }

            Log::info('User updated successfully', ['user' => $user]);

            // Update Role (Only Role, No Permissions)
            // $user->syncRoles([$request->role]);
            // Log::info('Role updated successfully', ['role' => $request->role]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'User updated successfully',
                    'user' => $user
                ], 200);
            } else {
                return redirect()->route('users.index')->with('success', 'User Updated Successfully');
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req, string $id)
    {
        if (!Gate::allows('delete-user')) {
            if ($req->wantsJson()) {
                return response()->json(['error' => 'You do not have permission to assign any role this user.'], 403);
            }

            return abort(403, 'You are Unauthorized for this task.');
        }
        try {
            // if (!auth()->check()) {
            //     Log::error('Unauthorized Access Attempt');
            //     return response()->json(['message' => 'Unauthorized'], 401);
            // }

            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->delete();
            Log::info('User deleted successfully', ['user_id' => $id]);

            if (request()->wantsJson()) {
                return response()->json(['message' => 'User deleted successfully'], 200);
            } else {
                return redirect()->route('users.index')->with('success', 'User Deleted Successfully');
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting user', 'error' => $e->getMessage()], 500);
        }
    }


    public function assignRoles(Request $req, $id)
    {
        if (!Gate::allows('assign-role')) {
            if ($req->wantsJson()) {
                return response()->json(['error' => 'You do not have permission to assign any role this user.'], 403);
            }

            return abort(403, 'You are Unauthorized for this task.');
        }

        $user = User::with('roles.permissions')->find($id);
        $roles = Role::all(); // Fetch all roles
        $permissions = Permission::all(); // Fetch all permissions

        if (request()->wantsJson()) {
            return response()->json([
                'user' => $user,
                'assigned_roles' => $user->roles->pluck('name'),
                // 'all_roles' => $roles,
                'assigned_permissions' => $user->roles->flatMap->permissions->pluck('name')->unique(),
                // 'all_permissions' => $permissions
            ]);
        }

        return view('superadmin.users.assign-roles', compact('user', 'roles', 'permissions'));
    }


    public function updateRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate request
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Sync selected roles
        $user->roles()->sync($request->roles ?? []);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Roles updated successfully!',
                'user' => $user->load('roles')
            ], 200);
        }

        return redirect()->route('users.index')->with('success', 'Roles updated successfully!');
    }
}
