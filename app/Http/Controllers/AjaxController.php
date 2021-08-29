<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointment;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function submitTempAppointment(StoreAppointment $request){
        $previous_temp_appointment = Appointment::query()->userCreated(auth()->user()->id)->temp(1)->get();
        if(!$previous_temp_appointment->isEmpty()){
            Appointment::destroy($previous_temp_appointment);
        }

        $data = $request->input();

        $data['user_created'] = auth()->user()->id;
        $data['is_temp'] = 1;
        $data['datetime'] = $data['date'].' '.$data['time'];

        unset($data['date']);
        unset($data['time']);

        Appointment::create($data);
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function getUsedDates(Request $request){
        $data = request()->validate([
            'date'=>'required|String',
            'doctor_id'=>'required|integer',
        ]);

        $used_times = Appointment::query()->doctor($data['doctor_id'])->datetime($data['date'])->get();
        $times = array();
        foreach ($used_times as $time){
            $exploded_time = explode(" ", $time['datetime']);
            $explode = explode(":", $exploded_time[1]);
            $times[] = $explode[0].":".$explode[1];
        }
        echo json_encode(array_unique($times));
    }

    public function getApiData(Request $request){
        $prescriptions = Prescription::all();
        if(!empty($request->user_email)){
            $data = request()->validate([
                'user_email'=>'email',
            ]);
            $user = User::query()->email($data['user_email'])->first();
            if($user)
                $prescriptions = Prescription::query()->user($user->id)->get();
        }
        echo json_encode($prescriptions);
    }
}
