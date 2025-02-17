@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create deal</div>
                <div class="card-body">
                    <form action="{{ route('deals.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">deal Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Visible to:</label>
                            <select class="form-control" name="level_id" id="">
                                @foreach ($visibilityLevels as $level)
                                    <option value="{{$level->id}}">
                                        {{$level->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Create deal</button>
                        <a href="{{ route('deals.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
