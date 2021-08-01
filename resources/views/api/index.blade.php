@extends('layouts.app')

@section('content')

@if($session)
    <div class="container">
        <label for="user_email">Enter user email: </label>
        <input id="user_email" type="email" name="user_email"/>(all records will be displayed without entered user email address)<br>
        <button id="get_prescriptions">Get data</button><hr>
        <div id='result_div'></div>
    </div>
@else
    <form action="/api/auth" method="post">
        @csrf
        <input type="password" name="api_password" />
        <input type="submit" value="Enter"/>
    </form>
@endif
@endsection
