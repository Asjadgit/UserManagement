@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit deals</div>
                <div class="card-body">
                    <form action="{{ route('deals.update', $deals->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Deals Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $deals->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="level_id" class="form-label">Visible to:</label>
                            <select class="form-control" name="level_id" id="visibilitySelect">
                                @foreach ($visibilityLevels as $level)
                                    <option value="{{ $level->id }}"
                                            data-description="{{ $level->description }}"
                                            @if($deals->visibilityAssignments->first() && $deals->visibilityAssignments->first()->visibility_level_id == $level->id) selected @endif>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Show Description Below the Select -->
                            <p id="visibilityDescription" class="mt-2 text-muted">
                                {{ $deals->visibilityAssignments->first()->visibility_level->description ?? '' }}
                            </p>
                        </div>

                        <button type="submit" class="btn btn-primary">Update deals</button>
                        <a href="{{ route('deals.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const select = document.getElementById("visibilitySelect");
        const description = document.getElementById("visibilityDescription");

        function updateDescription() {
            const selectedOption = select.options[select.selectedIndex];
            description.textContent = selectedOption.getAttribute("data-description");
        }

        // Initialize the description on page load
        updateDescription();

        // Update the description when selection changes
        select.addEventListener("change", updateDescription);
    });
</script>

@endsection
