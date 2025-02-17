@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Role</div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="permissions" class="form-label">Assign Permissions</label>
                            <div class="form-check">
                                @foreach($permissions as $permission)
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                           class="form-check-input"
                                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $permission->name }}</label><br>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Role</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
