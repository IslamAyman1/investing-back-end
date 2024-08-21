<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offer extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function company(){
        return $this->belongsTo(company::class);
    }
    public function freelances(){
        return $this->belongsTo(freelance::class);
    }
    public function investings(){
        return $this->belongsTo(freelance::class);
    }
}
