@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Team Management</div>
                    <div class="card-body">
                        <a href="{{ route('teams.create') }}" class="btn btn-primary mb-4">Add New Team</a>

                        <!-- Filter Dropdown -->
                        <form method="GET" action="{{ route('teams.index') }}" class="mb-3">
                            <label for="status">Filter by Status:</label>
                            <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Activated</option>
                                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Deactivated</option>
                            </select>
                        </form>

                        <table id="Table" class="table table-bordered mt-3 p-2">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Manager</th>
                                    <th>Members</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teams as $team)
                                    <tr>
                                        <td>{{ $team->name }}</td>
                                        <td>{{ $team->manager->name ?? 'N/A' }}</td>
                                        <td>{{ $team->members->count() }}</td>
                                        <td>
                                            {{ $team->status === 'active' ? 'Activated' : 'Deactivated' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('teams.show', $team->id) }}" class="btn btn-sm btn-info">
                                                View Team
                                            </a>
                                            <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm btn-success">
                                                Edit Team
                                            </a>

                                            <!-- Toggle Activation Button -->
                                            <form action="{{ route('toggle.team.status', $team->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $team->status === 'active' ? 'btn-danger' : 'btn-success' }}" 
                                                    onclick="askToggleConfirmation(event, '{{ $team->status }}')">
                                                    {{ $team->status === 'active' ? 'Deactivate Team' : 'Reactivate Team' }}
                                                </button>
                                            </form>

                                            <!-- Delete Team (Only if Inactive) -->
                                        @if ($team->status === 'inactive')
                                            <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this team permanently? Users will not deleted in this team only team is deleted.');">
                                                    Delete Team
                                                </button>
                                            </form>
                                        @endif
                                               
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($teams->isEmpty())
                            <p class="text-muted">No teams found for this status.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function askToggleConfirmation(event, status) {
            event.preventDefault();
            let message = status === 'active' ? 'Really want to deactivate this team?' : 'Really want to reactivate this team?';
            
            if (confirm(message)) {
                event.target.closest("form").submit();
            }
        }
    </script>
@endsection
