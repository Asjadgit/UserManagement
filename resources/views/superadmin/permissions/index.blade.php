@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Permissions Management</div>
                    <div class="card-body">
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-4">Add New Permission</a>

                        <table id="rolesTable" class="table table-bordered mt-3 p-2">
                            <thead>
                                <tr align="center">
                                    <th class="text-center">Permission Name</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr align="center">
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning">Edit</a>

                                            <a href="{{ route('delete', $permission->id) }}" class="btn btn-danger">Delete</a>
                                            {{-- <form action="{{ route('permissions.destroy', $permission) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form> --}}
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
    $(document).ready(function () {
        $('#rolesTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            "language": {
                "search": "Filter records:"
            }
        });
    });
</script>
@endsection
