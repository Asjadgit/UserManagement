@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Team</div>
                @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <div class="card-body">
                    <form action="{{ route('teams.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Team Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>


                        <div class="mb-3">
                            <label for="manager_id" class="form-lable">Team Manager</label>
                            <select name="manager_id" id="" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="description" class="form-label">Team Description</label>
                            <textarea type="text" name="description" class="form-control"></textarea>
                        </div>


                        <div class="mb-3">
                            <label for="mambers" class="form-lable">Team Members</label>
                            <select name="members[]" id="user_id" class="form-control" multiple>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Create Team</button>
                        <a href="{{ route('teams.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
