@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Make an appointment') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{route('appointments.store')}}">
                            @csrf
                            <div class="form-group row">
                                <label for="patient_id" class="col-md-4 col-form-label text-md-right">{{ __('Patient') }}</label>
                                <div class="col-md-6">
                                    <select name="patient_id" class="form-control js-example-basic-single appointment_patient">
                                        @foreach($users as $user)
                                            @if($user->role==1)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('patient_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_id" class="col-md-4 col-form-label text-md-right">{{ __('Doctor') }}</label>
                                <div class="col-md-6">
                                    <select name="doctor_id" class="form-control js-example-basic-single appointment_doctor">
                                        @foreach($users as $user)
                                            @if($user->role==2)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('doctor_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                                <div class="col-md-6">
                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror appointment_date" name="date" value="{{Carbon\Carbon::today()->format('Y-m-d')}}" required>

                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row d-flex justify-content-center">
                                <div class="card">
                                    <div class="card-header">{{ __('Time') }}</div>
                                    <div class="card-body">
                                        @foreach($time_array as $time)
                                            <input type="radio" value="{{$time}}" id="{{$time}}" name="time" class="appointment_time" required><label for="{{$time}}">{{$time}}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
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
