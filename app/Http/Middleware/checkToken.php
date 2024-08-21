<?php

namespace App\Http\Middleware;

use App\Traits\generalTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class checkToken  
{
    use generalTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$guard): Response
    {
           // this middleware check if user is login or not , if login ok , and if any person 
           // authenticate and want data check he is user or admin and get him data
        if($guard !== null){
            auth()->shouldUse($guard); // should use guard table of user or admin and so on
            $token = $request->get('authToken');
            $request->headers->set('authToken', (string) $token , true);
            $request->headers->set('Authorization',"Bearer".  $token , true);
             try{ 
                $user = JWTAuth::parseToken()->authenticate();             
              } 
             catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $t){
                 return  $this->Error('token_invalid',$t->getMessage());
            } 
            catch(\Tymon\JWTAuth\Exceptions\JWTException $t){
                 return $this->Error('unAuthorized');
             }
        }
        return $next($request);
    }
}
