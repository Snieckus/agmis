<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Faker\Provider\DateTime;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $time_array = array('08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00');
        $users = User::wherein('role', [1,2])->get();

        if(auth()->user()->role == User::RECEPTIONIST){
            return view('receptionists.create', compact('time_array', 'users'));
        }else if(auth()->user()->role == User::PATIENT){
            $appointments = Appointment::query()->temp(0)->patient(auth()->user()->id)->paginate(10);
            return view('patients.index', compact('time_array', 'users', 'appointments'));
        }else{
            $patients = User::where('role', 1)->paginate(10);
            return view('doctors.index', compact('patients'));
        }
    }
}
