<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Prescription extends Model
{
    use HasFactory;

    protected $with = ['user', 'drug'];

    protected $fillable = [
        'user_id',
        'drug_id',
        'valid_until',
    ];
    /**
     * @var mixed
     */
    private $created_at;

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function drug(){
        return $this->hasOne(Drug::class, 'id', 'drug_id');
    }

    public function scopeUser($query, $user)
    {
        return $query->where('user_id', $user);
    }
}
