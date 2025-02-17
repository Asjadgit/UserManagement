@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Group Details: {{ $group->name }}</h4>
                </div>
                <div class="card-body">
                    <h5>Group Name: {{ $group->name }}</h5>
                    <h5>Group Description: {{ $group->description }}</h5>

                    <p>
                        @if ($group->parent)
                            <strong>Parent Group:</strong> {{ $group->parent->name }}
                        @else
                            <strong>Parent Group:</strong> None
                        @endif
                    </p>

                    <hr>

                    <h5>Users in this Group:</h5>

                    @if ($group->users->isEmpty())
                        <p class="text-muted">No users in this group</p>
                    @else
                        <p><strong>Total Users:</strong> {{ $group->users->count() }}</p>
                        <ul class="list-group">
                            @foreach ($group->users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $user->name }}
                                    <form action="{{ route('visibility_groups.remove_user', ['groupid' => $group->id, 'userid' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="askconfirmation(event)">Remove</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <hr>

                    <h5>Add Users to Group</h5>
                    <form action="{{ route('assign-user', $group->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">Select Users</label>
                            <select name="user_id[]" id="user_id" class="form-control select2" multiple="multiple" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" 
                                        @if ($group->users->contains($user->id)) selected @endif>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2" onclick="askconfirmation(event)">Add Users</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function askconfirmation(event) {
        event.preventDefault(); // Prevent form submission first
        if (confirm('Really want to make changes?')) {
            event.target.closest("form").submit(); // Submit form if confirmed
        }
    }
</script>

@endsection
