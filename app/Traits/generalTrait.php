<?php
namespace App\Traits;


trait generalTrait{
   public function searchFunction($request, $col_name, $model_name){
      // $search = $request->coulamn_name;
   
      $result = $model_name::where ($col_name , 'like', "%$request->$col_name%")
     //  ->orWhere('description', 'like', "%$search%")
      ->get();
   
     return response()->json(['result' => $result]);
   
   }
public function successResponse($msg,$status){
   return response()->json([
      "msg"=>$msg,
      "status"=>$status
   ]);
}

public function faliedResponse($status,$msg){
   return response()->json([
     "status"=> 420,
     "msg" => $msg
   ]);
}
public function Error($msg){
    return response()->json([
        "msg"=>$msg
    ]);
}
public function validationError($validation){
     return $this->Error($validation->errors());
}
public function checkCodeForExistUser($code){
   $request = request();
   if($code !== $request->code){
      return "the code is wrong";
   }
   return $this->successResponse('ok',200);
}
}
?>