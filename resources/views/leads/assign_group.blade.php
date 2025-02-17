@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Assign Lead to a Group</div>
                <div class="card-body">
                    <form action="{{ route('leads.assignGroup', $lead->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="lead_id" value="{{$lead->id}}">
                            <label for="visibility_group_id">Select Group:</label>
                            <select name="visibility_group_id" class="form-control" required>
                                <option value="">-- Select Group --</option>
                                @foreach ($visibilityGroups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Assign</button>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
