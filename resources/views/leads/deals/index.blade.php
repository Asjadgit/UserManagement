@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">deals Management</div>
                    <div class="card-body">
                        <a href="{{ route('deals.create') }}" class="btn btn-primary mb-4">Add New deal</a>

                        <table id="Table" class="table table-bordered mt-3 p-2">
                            <thead>
                                <tr align="center">
                                    <th class="text-center">deal Name</th>
                                    <th class="text-center">Visibility Level</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deals as $deal)
                                    <tr align="center">
                                        <td>{{ $deal->name }}</td>
                                        <td>
                                            {{ $deal->visibilityAssignments->first()->visibilitylevel->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <!-- Assign to Group Button -->
                                            {{-- <a href="{{ route('deal.assignGroupForm', $deal->id) }}" class="btn btn-info">
                                                Assign to Group
                                            </a> --}}

                                            <a href="{{ route('deals.edit', $deal->id) }}" class="btn btn-warning">Edit</a>

                                            <form action="{{ route('deals.destroy', $deal->id) }}" method="POST"
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
