@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Plan Management</div>
                    <div class="card-body">
                        <a href="{{ route('plans.create') }}" class="btn btn-primary mb-4">Add New Plan</a>

                        <table id="currencyTable" class="table table-bordered mt-3 p-2">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Currency</th>
                                    <th>Frequency</th>
                                    <th>Trial Days</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plans as $plan)
                                    <tr>
                                        <td>{{ $plan->name }}</td>
                                        <td>{{ $plan->price }}</td>
                                        <td>{{ $plan->currency }}</td>
                                        <td>{{ ucfirst($plan->frequency) }}</td>
                                        <td>{{ $plan->trial_days }}</td>
                                        <td>{{ ucfirst($plan->type) }}</td>
                                        <td>
                                            <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-sm btn-info">View
                                                Plan</a>
                                            <a href="{{ route('plans.edit', $plan->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>

                                            <form action="{{ route('plans.destroy', $plan->id) }}" method="POST"
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
            $('#currencyTable').DataTable({
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
