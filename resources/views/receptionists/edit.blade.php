@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit appointment No. ').$appointment->id }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="/appointments/{{$appointment->id}}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="patient_id" class="col-md-4 col-form-label text-md-right"><b>{{ __('Patient') }}</b></label>
                                <label for="patient_id" class="col-md-4 col-form-label">{{ $appointment->p_name }}</label>
                            </div>

                            <div class="form-group row">
                                <label for="doctor_id" class="col-md-4 col-form-label text-md-right"><b>{{ __('Doctor') }}</b></label>
                                <label for="doctor_id" class="col-md-4 col-form-label">{{ $appointment->d_name }}</label>
                            </div>

                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label text-md-right"><b>{{ __('Date') }}</b></label>

                                <div class="col-md-6">
                                    <input id="date" type="date" class="form-control @error('date') is-invalid @enderror appointment_date" name="date" value="{{ $used_date }}" required>

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
                                            <input type="radio" value="{{$time}}" id="{{$time}}" name="time" class="appointment_time" required {{ ($used_time == $time.':00' ? 'checked' : '') }}><label for="{{$time}}">{{$time}}</label>
                                        @endforeach
                                    </div>
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
