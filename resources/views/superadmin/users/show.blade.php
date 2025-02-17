@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User Details - {{ $user->name }}</div>

                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Name:</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Roles:</th>
                                <td>
                                    @if($user->roles->isEmpty())
                                        <span class="text-muted">No roles assigned</span>
                                    @else
                                        {{ $user->roles->pluck('name')->join(', ') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Permissions:</th>
                                <td>
                                    @if($user->roles->isEmpty())
                                        <span class="text-muted">No permissions assigned</span>
                                    @else
                                        {{ $user->roles->flatMap->permissions->pluck('name')->unique()->join(', ') }}
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
