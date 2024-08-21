<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\verifyEmail;
use App\Models\freelance;
use App\Models\investingfreelance;
use App\Models\job;
use App\Models\otpnumber;
use App\Models\User;
use App\Models\userCv;
use App\Traits\generalTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class userAuthController extends Controller
{
    use generalTrait;
    
    public function userRegister(Request $request){
        //start validation
          $rules = [
             'name'=>'required|min:3|string',
             'email' => 'required|email|unique:users',
             'password'=>'required|min:5',
             'address'=>'required',
             'phoneNumber'=>'required|numeric|digits:11|unique:users',
             'clientType'=>'required|string'
          ];
          $validation = Validator::make([
             'name'=>$request->name,
             'email'=>$request->email,
             'password'=>$request->password,
             'address'=>$request->address,
             'phoneNumber'=>$request->phoneNumber,
             'clientType'=>$request->clientType
          ],$rules);
          if($validation->fails()){
              return $this->validationError($validation);
          }
          if($request->password !== $request->confirmPassword){
            return $this->Error('password or password Confirm is not match');
          }
            $userStored = User::create($request->all());

             $user = User::find($userStored->id);
             $generatedNumber = rand(10000,90000);
             otpnumber::create([
               'user_id'=>$user->id,
                'userCode'=>$generatedNumber
             ]);
             Mail::to($request->email)->send(new verifyEmail($user->otpNumber->userCode));
             return $this->successResponse($user->clientType,200);
   }
   public function checkCode(Request $request){ 
      
     $code = otpnumber::where('userCode',$request->verifyEmail)->first();
     try{   
          if(!$code){
            return "the code is wrong"; 
          }
            User::where('id',$code->user->id)->update(['isActive'=>1]);
            otpnumber::destroy($code->id);
       }
      catch(Exception $e){
       return $e->getMessage();
     }
     return $this->successResponse('login',200);

    }
   public function userLogin(Request $request){
    $rules = [
      'email'=>'required|exists:users',
      'password'=>'required',
      'clientType'=>'required'
   ];
   $validation = Validator::make([
     'email'=>$request->email,
     'password'=>$request->password,
     'clientType'=>$request->clientType
   ],$rules);
   if($validation->fails()){
       return $this->validationError($validation);
   }
 $user =  User::where('email',$request->email)->first();
   if($request->clientType !== $user->clientType){
      return $this->Error('unAuthorized');
   }
  //  $userActive = User::where('email',$request->email)->first();   
  //  if($userActive->isActive == 0){
  //     return "please verify Your Email";
  //  }
   $credintial = $request->only(['email','password']);
   $token = Auth::guard('user-api')->attempt($credintial);
   if(!$token){
     return $this->Error('this is no user');
   }
    // deleteToken::dispatch("$request->email")->delay(now()->second(40));
   $user = Auth::guard('user-api')->user();
   User::where('email',$user->email)->update([
     'userToken'=>$token
   ]);
  //  $time = Carbon::now()->subHour();
  //  User::where('created_at', '<', $time)
  //       ->delete('userToken');
  
   return response()->json([
     'userToken'=>$token,
     'status'=>200
   ]);
   }
  public function checkTokenStatus(){
     return 'ok';
  }

   public function checkEmailAndSendCode(Request $request){
         $user = User::where('email',$request->email)->first();
         if(!$user){
             return $this->Error('Not Found');
         }else if($user->isActive == 0){
             return $this->Error('please Active Your Email');
         }
         $generatedNumber = rand(10000,90000);
        //  if($user->otpNumber->userCode !== null){
        //    return "the code is sended";
        //  }
         otpnumber::create([
          'user_id'=>$user->id,
           'userCode'=>$generatedNumber
        ]);
         Mail::to($request->email)->send(new verifyEmail($user->otpNumber->userCode));
        $this->CheckSendedCode($user->otpNumber->userCode);
       return $this->successResponse('the code is sended',200);
   }

   public function userProfile(){
    return Auth::user();
  }

   public function addInvestingProject(Request $request){
            $rules = [
              'projectTitle'=>'required',
              'description'=>'required',
              'projectBalance'=>'required',
              'investorNumber'=>'required',
              'photo'=>'image|mimes:jpeg,png,jpg'
          ];
          $validation = Validator::make($request->all(),$rules);
          if($validation->fails()){
              return $this->validationError($validation);
          }
        $image = $request->photo;
        $name = $image->getClientOriginalName();
        $path = public_path('upload');
        $image->move($path,$name);
        
        investingfreelance::create([
              'projectTitle'=>$request->projectTitle,
              'description'=>$request->description,
              'projectBalance'=>$request->projectBalance,
              'investorNumber'=>$request->investorNumber, 
              'photo'=> 'upload\\'.$name ,
              'user_id'=> Auth::user()->id
        ]);
     return "succefully";
   }
   public function addFreelanceProject(Request $request){
    $rules = [
      'freelanceName'=>'required',
      'freelanceBudget'=>'required',
      'freelanceTime'=>'required',
      'skills'=>'required',
      'description'=>'required',
      'photo'=>'image|mimes:jpeg,png,jpg',
      'authToken' => 'required'
  ];
  $validation = Validator::make($request->all(),$rules);
  if($validation->fails()){
      return $this->validationError($validation);
  }
$image = $request->photo;
$name = $image->getClientOriginalName();
$path = public_path('upload');
$image->move($path,$name);

   freelance::create([
    'freelanceName'=>$request->freelanceName,
    'freelanceBudget'=>$request->freelanceBudget,
    'freelanceTime'=>$request->freelanceTime,
    'skills'=>$request->skills,
    'description'=>$request->description,
    'photo'=>'upload\\'.$name,
    'user_id'=>Auth::user()->id
  ]);
return "ok";  
}
   public function getImage(){
      return  investingfreelance::select('id','projectTitle','description','photo','investorNumber','projectBalance')
      ->limit(3)
      ->get();
   }
   

   public function getData(){
    $test =  investingfreelance::where('id',1)->first()->oneInvestorPost;
     return $test;
   }
   public function updateProfile(Request $request){
    
      $user = User::where('email',$request->email)->first();

      $rules = [
        'name'=>'required|min:3|string',
        'email' => 'required|email',
        'address'=>'required',
        'phoneNumber'=>'required|numeric|digits:11',
     ]; 
     $validation = Validator::make([
        'name'=>$request->name,
        'email'=>$request->email,
        'address'=>$request->address,
        'phoneNumber'=>$request->phoneNumber,
        'password'=>$request->password  ,
        'photo'=>$request->photo,
     ],$rules);
     
     if($validation->fails()){
         return $this->validationError($validation);
     }
      if($request->photo !== null){
        $image = $request->photo;
        $name = $image->getClientOriginalName();
        $path = public_path('photoProfile');
        $image->move($path,$name);
        $user->update([
          'name'=>$request->name,
          'email'=>$request->email,
          'address'=>$request->address,
          'phoneNumber'=>$request->phoneNumber,
          'password'=>$request->password == null? Auth::user()->password : $request->password,
          'photo'=>'photoProfile\\'.$name 
        ]);   
        return 'updated with photo';
      }else{
        $user->update([
          'name'=>$request->name,
          'email'=>$request->email,
          'address'=>$request->address,
          'phoneNumber'=>$request->phoneNumber,
          'password'=>$request->password == null? Auth::user()->password : $request->password,
          'photo'=> $request->photo == null ? Auth::user()->photo :  $request->photo
        ]);   
        return 'update without photo';
      }
    
    return true;
   }
   public function getInvestingProject(){
    return investingfreelance::get();
   }
   public function search(Request $request){
     if($request->searchInPagination){
      $search = $request->searchInPagination;
      $result = investingfreelance::where('projectTitle' , 'like', "%$search%")->get(); 
     }
     return response()->json(['result' => $result]);
}
public function searchFreelance(Request $request){
  if($request->searchInPagination){
   $search = $request->searchInPagination;
   $result = freelance::where('projectTitle' , 'like', "%$search%")->get(); 
  }
  return response()->json(['result' => $result]);
}
  public function investingPagination(){
  $paginator =  investingfreelance::paginate(4);
  return $paginator;
  }
  public function freelancePagination(){
  $paginator =  freelance::paginate(4);
  return $paginator;
  }
  public function testRelation(){
    return User::select('id','name')->limit(1)->get();
  }
  public function logout(){
    auth()->logout();
    return response()->json(['msg' => 'Successfully logged out']);
}
public function addCv(Request $request){
  $rules = [
    'name'=>'required',
    'skills'=>'required',
    'education'=>'required',
    'phone'=>'required',
    'address'=>'required',
    'email'=>'required|email:dns,rfc',
    'linkedIn' => 'required' ,
    'Birthday' => 'required' ,
    'Nationality' => 'required' ,
    'marital_Status' => 'required' ,
    'military_Service' => 'required' ,
    'career_objective' => 'required', 
    'projects' => 'required' 
];
$validation = Validator::make($request->all(),$rules);
if($validation->fails()){
    return $this->validationError($validation);
}
$userCv = userCv::create([
  'name' => $request->name,
  'skills' => $request->skills,
  'education' => $request->education,
  'phone' => $request->phone,
  'address' => $request->address,
  'email' => $request->email,
  'linkedIn' => $request->linkedIn,
  'Birthday' => $request->Birthday,
  'Nationality' => $request->Nationality,
  'marital_Status' => $request->marital_Status,
  'military_Service' => $request->military_Service,
  'career_objective' => $request->career_objective,
  'projects' => $request->projects,
  'user_id' => Auth::user()->id
]);
return $this->successResponse('CV is Created',200);
}
public function getCvInfo(){
   $userCv = Auth::user()->userCv;
   return $this->successResponse($userCv,200);
}
public function addJob(Request $request){
  $rules = [
    'jobTitle'=>'required',
    'skills'=>'required',
    'Salary'=>'required',
    'description'=>'required',
];
$validation = Validator::make($request->all(),$rules);
if($validation->fails()){
    return $this->validationError($validation);
}
 job::create([
   'jobTitle'=>$request->jobTitle,
   'skills'=>$request->skills,
   'Salary'=>$request->Salary,
   'description'=>$request->description,
   'CompanyId'=>Auth::user()->id
 ]);
 return $this->successResponse('succefully',200);
}
public function generatePdf(Request $request){
  $filename = $request->name;
  $pdf = PDF::loadView('generator',compact('filename'))->download($filename.'pdf');
  Storage::disk('files')->put($filename.'.pdf' , $pdf);
  return $pdf; 
}
public function getUserProjects(Request $request){
 $postedProject = Auth::user()->id;
 if($request->keyPro == 'invest'){
  $result = investingfreelance::where('user_id',$postedProject)->get();
     return response()->json(['result'=>$result]);
 }else{
  return $this->successResponse($postedProject->postManyFreelances,200);
 }
}
}

