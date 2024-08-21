<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;
    protected $fillable = ['name','email','password','phoneNumber','address'];
    public function jobs(){
        return $this->hasMany(job::class,'company_id');
    }
    public function payments(){
        return $this->hasMany(payment::class);
    }
    public function investings(){
        return $this->belongsToMany(investingfreelance::class,'company_investingfreelance');
    }
    public function offers(){
        return $this->hasMany(offer::class);
    }
}
