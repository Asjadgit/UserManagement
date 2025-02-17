@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Users Management</div>
                    <div class="card-body">
                        <a href="{{ route('users.create') }}" class="btn btn-primary mb-4">Add New User</a>

                        <table id="Table" class="table table-bordered mt-3 p-2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Roles</th>
                                    <th>Permissions</th>
                                    <th>Actions</th> <!-- New column for actions -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <!-- Display Meta Fields -->
                                        <td>
                                            {{ $user->getMeta('phone') ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $user->getMeta('address') ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-primary">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                @foreach ($role->permissions as $permission)
                                                    <span class="badge bg-success">{{ $permission->name }}</span>
                                                @endforeach
                                            @endforeach
                                        </td>
                                        <td>
                                            <!-- Show User -->
                                            <a href="{{ route('users.show', $user->id) }}"
                                                class="btn btn-info btn-sm">Show</a>

                                            <!-- Edit User -->
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>

                                            <!-- Assign Roles & Permissions -->
                                            <a href="{{ route('users.assignRoles', $user->id) }}"
                                                class="btn btn-secondary btn-sm">Assign Roles</a>

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#rolesTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "language": {
                    "search": "Filter records:"
                }
            });
        });
    </script>
@endsection
