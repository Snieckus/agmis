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
                            <form action="/appointments/{{$app->id}}" method="post" style='display:inline;' >
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="app_id" value="{{$app->id}}"/>
                                <i style="float: right;  cursor:pointer" onclick="$(this).closest('form').submit()"  class="fas fa-trash-alt delete_advice "></i>
                            </form>
                            <form action="/appointments/{{$app->id}}/edit" method="get" style='display:inline;' >
                                @csrf
                                <i style="float: right;  cursor:pointer" onclick="$(this).closest('form').submit()"  class="fa fa-edit delete_advice "></i>
                            </form>
                        </div>
                        <div class="card-body">
                            <b>Patient: </b>{{$app->p_name}}<br>
                            <b>Doctor: </b>{{$app->d_name}}<br>
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
