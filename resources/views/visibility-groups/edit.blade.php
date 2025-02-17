@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Group</div>
                    <div class="card-body">
                        <form action="{{ route('visibility_groups.update', $group->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Group Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Group Name</label>
                                <input type="text" name="name" id="name" class="form-control" maxlength="70"
                                    value="{{ old('name', $group->name) }}" required>
                                <small id="nameCounter" class="text-muted">0/70</small>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" maxlength="255">{{ old('description', $group->description) }}</textarea>
                                <small id="descCounter" class="text-muted">0/255</small>
                            </div>

                            <!-- Parent Group (Optional) -->
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Group (Optional)</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach ($visibilityGroups as $parentGroup)
                                        <option value="{{ $parentGroup->id }}"
                                            {{ $group->parent_id == $parentGroup->id ? 'selected' : '' }}>
                                            {{ $parentGroup->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit & Back Buttons -->
                            <button type="submit" class="btn btn-primary">Update Group</button>
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
            function updateCounter(input, counter, maxLength) {
                counter.textContent = `${input.value.length}/${maxLength}`;
            }

            const nameInput = document.getElementById("name");
            const nameCounter = document.getElementById("nameCounter");
            const descInput = document.getElementById("description");
            const descCounter = document.getElementById("descCounter");

            // Initialize counters
            updateCounter(nameInput, nameCounter, 70);
            updateCounter(descInput, descCounter, 255);

            // Add event listeners
            nameInput.addEventListener("input", function() {
                updateCounter(nameInput, nameCounter, 70);
            });

            descInput.addEventListener("input", function() {
                updateCounter(descInput, descCounter, 255);
            });
        });
    </script>
@endsection
