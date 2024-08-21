<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otpnumber extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','userCode'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
