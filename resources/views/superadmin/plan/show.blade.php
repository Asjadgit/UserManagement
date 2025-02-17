@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Plan Details: {{ $plan->name }}</div>
                    <div class="card-body">
                        <h5>Plan Name: {{ $plan->name }}</h5>
                        <hr>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr align="center">
                                    <th class="text-center">Plan Name</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Frequency</th>
                                    <th class="text-center">Trial Days</th>
                                    <th class="text-center">Type</th>
                                    <th>Features</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <td>{{ $plan->name }}</td>
                                    <td>{{ $plan->currency }}</td>
                                    <td>{{ $plan->price }}</td>
                                    <td>{{ $plan->frequency }}</td>
                                    <td><b>{{ $plan->trial_days }}</b></td>
                                    <td><b>{{ $plan->type }}</b></td>
                                    <td>
                                        <ul>
                                            @foreach (json_decode($plan->features, true) ?? [] as $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('plans.index') }}" class="btn btn-secondary">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
