<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory;
    public $timestamps = true;
    protected $table="users";
    protected $fillable=['name','email','password','phoneNumber','address','clientType','photo'];
    protected $casts = [
        'password' => 'hashed',
    ];
    protected $hidden = ['isActive','created_at','updated_at'];

    
    public function freelances(){
        return $this->belongsToMany(freelance::class,'user_freelance');
    }
    public function postManyFreelances(){
        return $this->hasMany(freelance::class,'user_id');
    }
    public function postManyInvesting(){
        return $this->hasMany(investingfreelance::class,'user_id');
    }
    public function userCv(){
        return $this->hasOne(userCv::class,'user_id');
    }
    public function jobs(){
        return $this->belongsToMany(job::class,'user_job');
    }
    public function payments(){
        return $this->hasMany(payment::class);
    }
    public function investings(){
        return $this->belongsToMany(investingfreelance::class,'user_investingfreelance');
    }
    public function offers(){
        return $this->hasMany(offer::class);
    }
    public function otpNumber(){
        return $this->hasOne(otpnumber::class);
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
