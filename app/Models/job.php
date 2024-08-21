<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function companyjobs(){
        return $this->belongsTo(company::class,'company_id');
    }
    public function users(){
        return $this->belongsToMany(User::class,'user_job');
    }
}
