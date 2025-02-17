@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Assign Roles & Permissions to {{ $user->name }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.updateRoles', ['id' => $user->id]) }}">
                            @csrf
                            @method('PUT')

                            <h5>Assign Roles</h5>
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                        class="form-check-input" {{ $user->roles->contains($role) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $role->name }}</label>
                                </div>
                            @endforeach

                            <h5 class="mt-3">Permissions (Inherited from Roles)</h5>

                            @php
                                // Get all assigned permissions from roles
                                $assignedPermissionIds = $user->roles->flatMap->permissions->pluck('id')->unique();
                            @endphp

                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"
                                        {{ $assignedPermissionIds->contains($permission->id) ? 'checked' : '' }} disabled>
                                    <label class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-success mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
