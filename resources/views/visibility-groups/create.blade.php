@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Visibility Group</div>
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
                        <form action="{{ route('visibility_groups.store') }}" method="POST">
                            @csrf

                            <!-- Group Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Group Name</label>
                                <input type="text" name="name" id="name" class="form-control" maxlength="70" required>
                                <small id="nameCounter" class="text-muted">70 characters</small>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" maxlength="255"></textarea>
                                <small id="descCounter" class="text-muted">255 characters</small>
                            </div>

                            <!-- Parent Group (Optional) -->
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Group (Optional)</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach($visibilityGroups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit & Back Buttons -->
                            <button type="submit" class="btn btn-success">Create Group</button>
                            <a href="{{ route('visibility_groups.index') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- JavaScript for Character Counter -->
     <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nameInput = document.getElementById("name");
            const nameCounter = document.getElementById("nameCounter");
            const descInput = document.getElementById("description");
            const descCounter = document.getElementById("descCounter");

            nameInput.addEventListener("input", function() {
                nameCounter.textContent = `${nameInput.value.length}/70`;
            });

            descInput.addEventListener("input", function() {
                descCounter.textContent = `${descInput.value.length}/255`;
            });
        });
    </script>
@endsection
