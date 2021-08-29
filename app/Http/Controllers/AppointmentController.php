<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointment;
use App\Http\Requests\UpdateAppointment;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Session\Store;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        if(auth()->user()->role == User::PATIENT){
            $appointments = Appointment::query()->temp(0)->patient(auth()->user()->id)->paginate(9);
        }
        $appointments = Appointment::query()->temp(0)->paginate(9);
        return view('receptionists.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        if (auth()->user()->role == User::RECEPTIONIST){
            $time_array = array('08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00');
            $users = User::whereIn('role', [1, 2])->get();
            return view('receptionists.create', compact('time_array', 'users'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAppointment $request
     * @return Application|Factory|View|Response
     */
    public function store(StoreAppointment $request)
    {
        $time_array = array('08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00');
        $users = User::whereIn('role', [1, 2])->get();

        $previous_temp_appointment = Appointment::query()->userCreated(auth()->user()->id)->temp(1)->get();
        if(!$previous_temp_appointment->isEmpty()){
            Appointment::destroy($previous_temp_appointment);
        }

        $data = $request->input();

        $used_times = Appointment::query()->doctor($data['doctor_id'])->datetime($data['date'])->get();
        foreach ($used_times as $time){
            $exploded_time = explode(" ", $time['datetime']);
            $explode = explode(":", $exploded_time[1]);
            $times[] = $explode[0].":".$explode[1];
            if($data['time'] == $explode[0].":".$explode[1]){
                $appointments = Appointment::query()->temp(0)->paginate(9);
                return view('receptionists.index', compact('time_array', 'users', 'appointments'))->with('status', 'This time is taken, please select other time or date for this doctor');
            }
        }

        $data['datetime'] = $data['date'] . ' ' . $data['time'];
        $data['user_created'] = auth()->user()->id;
        unset($data['date']);
        unset($data['time']);

        Appointment::create($data);

        if (auth()->user()->role == User::RECEPTIONIST){
            $appointments = Appointment::query()->temp(0)->paginate(9);
            return view('receptionists.index', compact('time_array', 'users', 'appointments'))->with('status', 'Appointment made');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Appointment $appointment
     * @return Application|Factory|View|Response
     */
    public function edit(Appointment $appointment)
    {
        $used_datetime = explode(" ", $appointment->datetime);
        $used_date = $used_datetime[0];
        $used_time= $used_datetime[1];
        $time_array = array('08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00');
        return view('receptionists.edit', compact('time_array','appointment', 'used_date', 'used_time'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAppointment $request
     * @param Appointment $appointment
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(UpdateAppointment $request, Appointment $appointment)
    {
        $data = $request->input();
        $data['datetime'] = $data['date'] . ' ' . $data['time'];
        unset($data['date']);
        unset($data['time']);

        $appointment->update($data);
        return redirect('/appointments')->with('status', 'Appointment updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Appointment $appointment
     * @return RedirectResponse
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        $appointments = Appointment::query()->temp(0)->paginate(9);
        return redirect()->route('appointments.index', compact('appointments'))->with('status', 'Appointment deleted');
    }
}
