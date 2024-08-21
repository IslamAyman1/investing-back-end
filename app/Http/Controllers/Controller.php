<?php

namespace App\Http\Controllers;

use App\Models\freelanceproject;
use App\Models\freelanceProjectInfo;
use App\Models\user;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    // public function getUserProject(){
    //     $userProject = freelanceproject::find(1);
    //     return $userProject->users;
    // }
}
