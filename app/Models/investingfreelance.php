<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class investingfreelance extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function companies(){
        return $this->belongsToMany(company::class,'company_investingfreelance');
    }
    public function oneInvestorPost(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function users(){
        return $this->belongsToMany(User::class,'user_investingfreelance');
    }
    public function offers(){ 
        return $this->hasMany(offer::class);
    }
}
