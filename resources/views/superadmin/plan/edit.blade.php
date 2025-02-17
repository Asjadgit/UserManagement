@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Plan</div>
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
                        <form action="{{ route('plans.update', $plan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name:</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $plan->name) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Price:</label>
                                        <input type="number" name="price" step="0.01" class="form-control"
                                            value="{{ old('price', $plan->price) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Currency:</label>
                                        <select name="currency" class="form-control">
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->code }}"
                                                    {{ old('currency', $plan->currency) == $currency->code ? 'selected' : '' }}>
                                                    {{ $currency->currency . ' - ' . $currency->code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Frequency:</label>
                                        <select name="frequency" class="form-control">
                                            <option value="week"
                                                {{ old('frequency', $plan->frequency) == 'week' ? 'selected' : '' }}>Weekly
                                            </option>
                                            <option value="month"
                                                {{ old('frequency', $plan->frequency) == 'month' ? 'selected' : '' }}>
                                                Monthly</option>
                                            <option value="year"
                                                {{ old('frequency', $plan->frequency) == 'year' ? 'selected' : '' }}>Yearly
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Trial Days:</label>
                                        <input type="number" name="trial_days" class="form-control" min="0"
                                            value="{{ old('trial_days', $plan->trial_days) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Type:</label>
                                        <select name="type" class="form-control">
                                            <option value="subscription"
                                                {{ old('type') == 'subscription' ? 'selected' : '' }}>Subscription</option>
                                            <option value="one-time" {{ old('type') == 'one-time' ? 'selected' : '' }}>
                                                One-time</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Features:</label>
                                        <input type="text" name="features[]" class="form-control"
                                            value="{{ old('features.0', isset($plan->features) ? json_decode($plan->features, true)[0] ?? '' : '') }}"
                                            placeholder="Enter a feature">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"></label>
                                        <input type="text" name="features[]" class="form-control mt-2"
                                            value="{{ old('features.1', isset($plan->features) ? json_decode($plan->features, true)[1] ?? '' : '') }}"
                                            placeholder="Enter another feature">
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <!-- Ensures unchecked state is sent -->
                                <input type="checkbox" name="is_featured" class="form-check-input"
                                    {{ old('is_featured', $plan->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label">Featured Plan</label>
                            </div>

                            <div class="form-check mb-3">
                                <!-- Ensures unchecked state is sent -->
                                <input type="checkbox" name="is_free" class="form-check-input"
                                    {{ old('is_free', $plan->is_free) ? 'checked' : '' }}>
                                <label class="form-check-label">Free Plan</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Plan</button>
                            <a href="{{ route('plans.index') }}" class="btn btn-secondary">Go back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
