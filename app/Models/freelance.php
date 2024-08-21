<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class freelance extends Model
{
    use HasFactory;
    protected $fillable=['freelanceName','freelanceBudget','freelanceTime','skills','description','user_id'];
    protected $hidden=['created_at','updated_at'];
    public function users(){
        return $this->belongsToMany(User::class,'user_freelance');
    } 
    public function offers(){
        return $this->hasMany(offer::class);
    }
    public function oneFreelancerPost(){
        return $this->belongsTo(User::class,'user_id');
    }
}   
