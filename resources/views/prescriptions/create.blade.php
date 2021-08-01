@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create prescription') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('prescriptions.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="user_id" class="col-md-4 col-form-label text-md-right">{{ __('Patient') }}</label>
                                <div class="col-md-6">
                                    <select name="user_id" class="form-control js-example-basic-single">
                                        @foreach($patients as $patient)
                                            <option value="{{$patient->id}}">{{$patient->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="drug_id" class="col-md-4 col-form-label text-md-right">{{ __('Drug') }}</label>
                                <div class="col-md-6">
                                    <select name="drug_id" class="form-control js-example-basic-single">
                                        @foreach($drugs as $drug)
                                            <option value="{{$drug->id}}">{{$drug->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('drug_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="valid_until" class="col-md-4 col-form-label text-md-right">{{ __('Valid until') }}</label>

                                <div class="col-md-6">
                                    <input id="valid_until" type="date" class="form-control @error('valid_until') is-invalid @enderror" name="valid_until" value="{{Carbon\Carbon::today()->format('Y-m-d')}}" required>

                                    @error('valid_until')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
