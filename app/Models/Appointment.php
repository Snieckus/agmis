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

    protected $with = ['doctor', 'patient'];

    public function patient(){
        return $this->hasOne(User::class, 'id','patient_id');
    }

    public function doctor(){
        return $this->hasOne(User::class, 'id','doctor_id');
    }

    public function scopeTemp($query, $isTemp)
    {
        return $query->where('is_temp', $isTemp);
    }

    public function scopeDoctor($query, $doctor)
    {
        return $query->where('doctor_id', $doctor);
    }

    public function scopePatient($query, $patient)
    {
        return $query->where('patient_id', $patient);
    }

    public function scopeDatetime($query, $date)
    {
        return $query->where('datetime', 'like', $date.'%');
    }

    public function scopeUserCreated($query, $user)
    {
        return $query->where('user_created', $user);
    }
}
