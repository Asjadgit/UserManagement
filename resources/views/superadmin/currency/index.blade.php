@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Currency Management</div>
                    <div class="card-body">
                        <a href="{{ route('currencies.create') }}" class="btn btn-primary mb-4">Add New Currency</a>

                        <table id="currencyTable" class="table table-bordered mt-3 p-2">
                            <thead>
                                <tr align="center">
                                    <th class="text-center">Country Name</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Symbol</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($currencies as $currency)
                                    <tr align="center">
                                        <td>{{ $currency->country }}</td>
                                        <td>{{ $currency->currency }}</td>
                                        <td>{{ $currency->code }}</td>
                                        <td>{{ $currency->symbol }}</td>
                                        <td>
                                            <a href="{{ route('currencies.show', $currency->id) }}" class="btn btn-info">View</a>
                                            <a href="{{ route('currencies.edit', $currency->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('currencies.destroy', $currency->id) }}" method="POST"
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
        $('#currencyTable').DataTable({
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
