<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\testMail;
use App\Models\User;
use App\Models\userCv;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class userController extends Controller
{
    public function getUserProject(){
        $user = User::find(1);
        return $user->freelances[0]->skills;
    }
    public function getUserCv(){
      $user = user::with('userCv')->find(1);
      return $user;
    }
    public function getJob(){
        $company = User::find(1)->jobs[0]->company->count();
        return $company;
    }
    public function sendEmail(){
        $data = ['how are you'];
       try{
        Mail::to('is606ay@gmail.com')->send(new testMail($data));
        return 'success';
       }catch(Exception $e){
          return 'failed';
       }
    }
    public function generatePdf(){
        $usercv = Auth::user()->userCv;

        // $fileName = "$usercv->name"; 
        // $pdf = PDF::loadView('generator',$usercv)->download($fileName);
        // Storage::disk('files')->put($fileName, $pdf);
        // return 'the Cv Is Created'; 
        return view('generator',compact('usercv'));
    }
} 
