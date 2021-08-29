<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthApi;
use App\Models\Appointment;
use Illuminate\Contracts\Foundation\Application;
use Session;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $session = Session::get('api');
        return view('api.index', compact('session'));
    }

    public function auth(AuthApi $request)
    {
        $data = $request->input();
        if($data['api_password'] == env('API_PASSWORD', 'fakePass')){
            Session::put('api', '1');
        }
        $session = Session::get('api');
        return view('api.index', compact('session'));
    }
}
