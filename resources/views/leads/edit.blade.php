@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Lead</div>
                <div class="card-body">
                    <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Lead Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $lead->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="level_id" class="form-label">Visible to:</label>
                            <select class="form-control" name="level_id" id="level_id">
                                @foreach ($visibilityLevels as $level)
                                    <option value="{{ $level->id }}"
                                        @if($lead->visibilityAssignments->first() && $lead->visibilityAssignments->first()->visibility_level_id == $level->id) selected @endif>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Lead</button>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
