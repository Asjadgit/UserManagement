@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit {{$currency->currency}}</div>
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
                        <form action="{{ route('currencies.update',$currency->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="country" class="form-label">Country Name</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{$currency->country}}" required>
                            </div>

                            <div class="mb-3">
                                <label for="currency" class="form-label">Currency Name</label>
                                <input type="text" class="form-control" id="currency" name="currency" value="{{$currency->currency}}" required>
                            </div>

                            <div class="mb-3">
                                <label for="code" class="form-label">Currency Code</label>
                                <input type="text" class="form-control" id="code" name="code" value="{{$currency->code}}" required>
                            </div>

                            <div class="mb-3">
                                <label for="symbol" class="form-label">Currency Symbol</label>
                                <input type="text" class="form-control" id="symbol" name="symbol" value="{{$currency->symbol}}" required>
                            </div>

                            <div class="mb-3">
                                <label for="thousand_separator" class="form-label">Thousand Separator</label>
                                <input type="text" class="form-control" id="thousand_separator" name="thousand_separator" maxlength="1" placeholder="e.g., , or ." value="{{$currency->thousand_separator}}">
                            </div>

                            <div class="mb-3">
                                <label for="decimal_separator" class="form-label">Decimal Separator</label>
                                <input type="text" class="form-control" id="decimal_separator" name="decimal_separator" maxlength="1" placeholder="e.g., . or ," value="{{$currency->decimal_separator}}">
                            </div>

                            <button type="submit" class="btn btn-primary">Update Currency</button>

                            <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
