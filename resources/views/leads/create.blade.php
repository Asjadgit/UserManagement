@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create lead</div>
                <div class="card-body">
                    <form action="{{ route('leads.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Lead Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="level_id" class="form-label">Visible to:</label>
                            <select class="form-control" name="level_id" id="visibilitySelect">
                                @foreach ($visibilityLevels as $level)
                                    <option value="{{ $level->id }}"
                                        data-description="{{ $level->description }}"
                                        data-name="{{ $level->name }}"
                                        {{ $level->name == "Item owner's visibility group" ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Show Description Below the Select -->
                            <p id="visibilityDescription" class="mt-2 text-muted">
                                {{ $visibilityLevels->where('name', "Item owner's visibility group")->first()->description ?? '' }}
                            </p>
                        </div>

                        <button type="submit" class="btn btn-success">Create lead</button>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary">Back</a>
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

        function updateSelectionIcon() {
            for (let i = 0; i < select.options.length; i++) {
                let option = select.options[i];
                let name = option.getAttribute("data-name");

                // Check if this option is selected
                if (option.selected) {
                    option.textContent = name + " ✔️";  // Add check mark
                } else {
                    option.textContent = name;  // Remove check mark
                }
            }
        }

        // Update description and tick on selection change
        select.addEventListener("change", function () {
            const selectedOption = select.options[select.selectedIndex];
            description.textContent = selectedOption.getAttribute("data-description");
            updateSelectionIcon();
        });

        // Initialize the selection icon on page load
        updateSelectionIcon();
    });
</script>

@endsection
