@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Currecny Details: {{ $currency->currency }}</div>
                    <div class="card-body">
                        <h5>Currecny Name: {{ $currency->currency }}</h5>
                        <hr>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr align="center">
                                    <th class="text-center">Country Name</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">Symbol</th>
                                    <th class="text-center">Thousand Seperator</th>
                                    <th class="text-center">Decimal Seperator</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center">
                                    <td>{{ $currency->country }}</td>
                                    <td>{{ $currency->currency }}</td>
                                    <td>{{ $currency->code }}</td>
                                    <td>{{ $currency->symbol }}</td>
                                    <td><b>{{ $currency->thousand_separator }}</b></td>
                                    <td><b>{{ $currency->decimal_separator }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ route('currencies.edit', $currency->id) }}"
                            class="btn btn-warning">Edit</a>
                        <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
