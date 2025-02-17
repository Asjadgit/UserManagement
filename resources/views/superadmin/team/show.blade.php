@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Team Details: {{ $team->name }}</div>
                    <div class="card-body">
                        <h4>Team Name: {{ $team->name }}</h5>
                        <h6>Team Manager: {{ $team->manager->name }}</h5>
                        <h6>Team Description: {{ $team->description }}</h5>
                        <hr>
                        <h5>Members:</h5>

                        @if ($team->members->count() > 0)
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($team->members as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">No members in this team.</p>
                        @endif

                        <a href="{{ route('teams.index') }}" class="btn btn-secondary mt-3">Back to Teams</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
