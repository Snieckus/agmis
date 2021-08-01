<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $appointments = Appointment::allAppointments();
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
            $users = User::wherein('role', [1, 2])->get();
            return view('receptionists.create', compact('time_array', 'users'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function store(Request $request)
    {
        $time_array = array('08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00');
        $users = User::wherein('role', [1, 2])->get();

        $previous_temp_appointment = Appointment::where('user_created', auth()->user()->id)->where('is_temp', 1);
        $previous_temp_appointment->delete();

        $data = request()->validate([
            'patient_id' => 'required|integer',
            'date' => 'required|String',
            'time' => 'required|String',
            'doctor_id' => 'required|integer',
        ]);

        $used_times = Appointment::select('datetime')->where('doctor_id', $data['doctor_id'])->where('datetime', 'like', $data['date'].'%')->get();
        foreach ($used_times as $time){
            $exploded_time = explode(" ", $time['datetime']);
            $explode = explode(":", $exploded_time[1]);
            $times[] = $explode[0].":".$explode[1];
            if($data['time'] == $explode[0].":".$explode[1]){
                $appointments = Appointment::allAppointments();
                return view('receptionists.index', compact('time_array', 'users', 'appointments'))->with('status', 'This time is taken, please select other time or date for this doctor');
            }
        }

        $data['datetime'] = $data['date'] . ' ' . $data['time'];
        $data['user_created'] = auth()->user()->id;
        unset($data['date']);
        unset($data['time']);

        Appointment::create($data);

        if (auth()->user()->role == User::RECEPTIONIST){
            $appointments = Appointment::allAppointments();
            return view('receptionists.index', compact('time_array', 'users', 'appointments'))->with('status', 'Appointment made');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id)
    {
        $appointment = Appointment::oneAppointment($id)[0];
        $used_datetime = explode(" ", $appointment->datetime);
        $used_date = $used_datetime[0];
        $used_time= $used_datetime[1];
        $time_array = array('08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00');
        return view('receptionists.edit', compact('time_array','appointment', 'used_date', 'used_time'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, int $id)
    {
        $data = request()->validate([
            'date' => 'required|String',
            'time' => 'required|String',
        ]);
        $data['datetime'] = $data['date'] . ' ' . $data['time'];
        unset($data['date']);
        unset($data['time']);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($data);
        return redirect('/appointments')->with('status', 'Appointment updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        $appointments = Appointment::where('is_temp', 0)->paginate(9);
        return redirect()->route('appointments.index', compact('appointments'))->with('status', 'Appointment deleted');
    }
}
