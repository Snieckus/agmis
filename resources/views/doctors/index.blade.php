@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Patients') }}</div>

                    <div class="card-body">
                        @if(count($patients) > 0)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patients as $patient)
                                        <tr>
                                            <td>{{$patient->id}}</td>
                                            <td>{{$patient->name}}</td>
                                            <td>{{$patient->email}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            No patients found.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
@endsection
