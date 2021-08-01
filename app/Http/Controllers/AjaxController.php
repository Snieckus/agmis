<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function submitTempAppointment(Request $request){
        $previous_temp_appointment = Appointment::where('user_created', auth()->user()->id)->where('is_temp', 1);
        $previous_temp_appointment->delete();

        $data = request()->validate([
            'patient_id'=>'required|integer',
            'date'=>'required|String',
            'time'=>'required|String',
            'doctor_id'=>'required|integer',
        ]);
        $data['is_temp'] = 1;
        $data['datetime'] = $data['date'].' '.$data['time'];
        unset($data['date']);
        unset($data['time']);
        $data['user_created'] = auth()->user()->id;

        Appointment::create($data);
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function getUsedDates(Request $request){
        $data = request()->validate([
            'date'=>'required|String',
            'doctor_id'=>'required|integer',
        ]);

        $used_times = Appointment::select('datetime')->where('doctor_id', $data['doctor_id'])->where('datetime', 'like', $data['date'].'%')->get();
        $times = array();
        foreach ($used_times as $time){
            $exploded_time = explode(" ", $time['datetime']);
            $explode = explode(":", $exploded_time[1]);
            $times[] = $explode[0].":".$explode[1];
        }
        echo json_encode(array_unique($times));
    }

    public function getApiData(Request $request){
        if(!empty($request->user_email)){
            $data = request()->validate([
                'user_email'=>'email',
            ]);
            $user = User::where('email', $data['user_email'])->first();
            if($user)
                $prescriptions = Prescription::userPrescriptions($user->id);
        }else{
            $prescriptions = Prescription::prescriptionsApi();
        }
        echo json_encode($prescriptions);
    }
}
