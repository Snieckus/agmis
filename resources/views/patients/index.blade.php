@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="row">
                <div class="col-lg-12 alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            @if(count($appointments) <= 0)
                <div class="col-md-4 pb-4">
                    <div class="card">
                        <div class="card-header">{{ __('Appointments') }}</div>
                        <div class="card-body">
                            There are no appointments!
                        </div>
                    </div>
                </div>
            @else
                @foreach($appointments as $app)
                    <div class="col-md-4 pb-4">
                        <div class="card">
                            <div class="card-header">{{ __('Appointment No. ').$app->id }}
                            </div>
                            <div class="card-body">
                                <b>Patient: </b>{{$app->patient->name}}<br>
                                <b>Doctor: </b>{{$app->doctor->name}}<br>
                                <b>Time: </b>{{$app->datetime}}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{ $appointments->links() }}
    </div>
@endsection
