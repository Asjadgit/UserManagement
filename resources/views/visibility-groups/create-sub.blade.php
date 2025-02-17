@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Sub-Group for "{{ $parentGroup->name }}"</div>
                    <div class="card-body">
                        <form action="{{ route('visibility_groups.store') }}" method="POST">
                            @csrf

                            <!-- Parent Group (Hidden) -->
                            <input type="hidden" name="parent_id" value="{{ $parentGroup->id }}">

                            <div class="mb-3">
                                <label for="name" class="form-label">Sub-Group Name</label>
                                <input type="text" name="name" id="name" class="form-control" maxlength="70" required>
                                <small id="nameCounter" class="text-muted">70 characters</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" maxlength="255"></textarea>
                                <small id="descCounter" class="text-muted">255 characters</small>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Sub-Group</button>
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
