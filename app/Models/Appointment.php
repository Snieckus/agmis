<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'datetime',
        'doctor_id',
        'is_temp',
        'user_created'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function allAppointments(){
        return DB::table('appointments')
            ->select('appointments.id', 'p.name as p_name', 'd.name as d_name', 'appointments.datetime')
            ->leftJoin('users as p', 'p.id', '=', 'appointments.patient_id')
            ->leftJoin('users as d', 'd.id', '=', 'appointments.doctor_id')
            ->where('appointments.is_temp', 0)->paginate(9);
    }

    public static function oneAppointment($id){
        return DB::table('appointments')
            ->select('appointments.id', 'p.name as p_name', 'd.name as d_name', 'appointments.datetime')
            ->leftJoin('users as p', 'p.id', '=', 'appointments.patient_id')
            ->leftJoin('users as d', 'd.id', '=', 'appointments.doctor_id')
            ->where('appointments.id', $id)->get(0);
    }
}
