@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ __('Prescriptions') }}<a href="prescriptions/create" style="float:right">Create prescription</a></div>
                    <div class="card-body">
                        @if(count($prescriptions) > 0)
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient name</th>
                                    <th>Drug name</th>
                                    <th>Valid until</th>
                                    <th>Created at</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($prescriptions as $prescription)
                                    <tr>
                                        <td>{{$prescription->id}}</td>
                                        <td>{{$prescription->p_name}}</td>
                                        <td>{{$prescription->d_name}}</td>
                                        <td>{{current(explode(" ",$prescription->valid_until))}}</td>
                                        <td>{{$prescription->created_at}}</td>
                                        <td>
                                            @if(strtotime($prescription->created_at. '+1 hour') >= strtotime(date('Y-m-d H:i:s')))
                                                <form action="/prescriptions/{{$prescription->id}}" method="post" style='display:inline;' >
                                                    @csrf
                                                    @method('DELETE')
                                                    <i title="Cancel" style="cursor:pointer" onclick="if(confirm('Are you sure?')){ $(this).closest('form').submit() }"  class="far fa-window-close"></i>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            No prescriptions found.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{ $prescriptions->links() }}
            </div>
        </div>
    </div>
@endsection
