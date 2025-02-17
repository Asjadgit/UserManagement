@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">leads Management</div>
                    <div class="card-body">
                        <a href="{{ route('leads.create') }}" class="btn btn-primary mb-4">Add New lead</a>

                        <table id="Table" class="table table-bordered mt-3 p-2">
                            <thead>
                                <tr align="center">
                                    <th class="text-center">lead Name</th>
                                    <th class="text-center">Visibility Level</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads as $lead)
                                    <tr align="center">
                                        <td>{{ $lead->name }}</td>
                                        <td>
                                            {{ $lead->visibilityAssignments->first()->visibilitylevel->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-warning">Edit</a>

                                            <!-- Assign to Group Button -->
                                            {{-- <a href="{{ route('leads.assignGroupForm', $lead->id) }}" class="btn btn-info">
                                                Assign to Group
                                            </a> --}}

                                            <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
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
