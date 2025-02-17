@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Members to {{ $team->name }}</div>
                    <div class="card-body">
                        <form id="addMembersForm">
                            @csrf
                            <table id="usersTable" class="table table-bordered mt-3 p-2">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Teams</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usersData as $user)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="user_ids[]" value="{{ $user['id'] }}"
                                                    class="user-checkbox"
                                                    {{ in_array($user['id'], $teamMemberIds) ? 'checked' : '' }}>
                                            </td>
                                            <td>{{ $user['id'] }}</td>
                                            <td>{{ $user['name'] }}</td>
                                            <td>{{ $user['email'] }}</td>
                                            <td>
                                                @if (count($user['teams']) > 0)
                                                    {{ implode(', ', $user['teams']) }} <!-- Display team names -->
                                                @else
                                                    <span class="text-muted">Not in any team</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary mt-3">Add Selected Members</button>
                            <a href="{{route('teams.index')}}" class="btn btn-secondary mt-3">Go Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
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

            let alreadySelected = @json($teamMemberIds); // Already selected members

            $('#addMembersForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                let selectedUsers = [];
                $('.user-checkbox:checked').each(function() {
                    selectedUsers.push(parseInt($(this).val()));
                });

                let newlyAdded = selectedUsers.filter(id => !alreadySelected.includes(id));
                let removedUsers = alreadySelected.filter(id => !selectedUsers.includes(id));

                if (newlyAdded.length === 0 && removedUsers.length === 0) {
                    alert('Already Members of the team.');
                    return;
                }

                $.ajax({
                    url: "{{ route('teams.addMembers', $team->id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_ids: selectedUsers
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload(); // Reload page to reflect changes
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Something went wrong. Please try again.');
                    }
                });
            });
        });
    </script>
@endsection
