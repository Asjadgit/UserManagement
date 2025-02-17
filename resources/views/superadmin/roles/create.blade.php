@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Role</div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="permissions" class="form-label">Assign Permissions</label>
                            <div class="form-check">
                                @foreach($permissions as $permission)
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input">
                                    <label class="form-check-label">{{ $permission->name }}</label><br>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Create Role</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
