<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'drug_id',
        'valid_until',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function drug(){
        return $this->hasOne(Drug::class);
    }

    public static function prescriptions(){
        return DB::table('prescriptions')
            ->select('prescriptions.id', 'p.name as p_name', 'd.name as d_name', 'prescriptions.valid_until', 'prescriptions.created_at')
            ->leftJoin('users as p', 'p.id', '=', 'prescriptions.user_id')
            ->leftJoin('drugs as d', 'd.id', '=', 'prescriptions.drug_id')
            ->paginate(9);
    }

    public static function prescriptionsApi(){
        return DB::table('prescriptions')
            ->select('prescriptions.id', 'p.name as p_name', 'd.name as d_name', 'prescriptions.valid_until', 'prescriptions.created_at')
            ->leftJoin('users as p', 'p.id', '=', 'prescriptions.user_id')
            ->leftJoin('drugs as d', 'd.id', '=', 'prescriptions.drug_id')
            ->get();
    }

    public static function userPrescriptions($user_id){
        return DB::table('prescriptions')
            ->select('prescriptions.id', 'p.name as p_name', 'd.name as d_name', 'prescriptions.valid_until', 'prescriptions.created_at')
            ->leftJoin('users as p', 'p.id', '=', 'prescriptions.user_id')
            ->leftJoin('drugs as d', 'd.id', '=', 'prescriptions.drug_id')
            ->where('prescriptions.user_id', $user_id)->get();
    }

}
