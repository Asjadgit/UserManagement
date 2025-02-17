@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Visibility Groups Management</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('visibility_groups.create') }}" class="btn btn-primary mb-3">Add New Group</a>

                    <table id="Table" class="table table-bordered mt-3 p-2">
                        <thead>
                            <tr align="center">
                                <th class="text-center">Visibility Group Name</th>
                                <th class="text-center">Parent Group</th>
                                <th class="text-center">Users Count</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $group)
                                <tr align="center">
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->parent ? $group->parent->name : 'None' }}</td>
                                    <td>{{ $group->users->count() }}</td>
                                    <td>
                                        <a href="{{ route('visibility_groups.show', $group->id) }}" class="btn btn-info btn-sm">View Group</a>

                                        <a href="{{ route('visibility_groups.edit', $group->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ route('visibility_groups.destroy', $group->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>

                                        <a href="{{ route('visibility_groups.create', ['parent_id' => $group->id]) }}" class="btn btn-success btn-sm">Add Sub-Group</a>
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
        $('#visibilityGroupsTable').DataTable({
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
