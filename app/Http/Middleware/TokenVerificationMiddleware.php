<?php

namespace App\Http\Middleware;
use App\Helper\JWTtoken;
use Closure;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response;
class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next):Response
    {
        $token=$request->cookie('token');
        $result = JWTToken::VerifyToken($token);
        if($result=='unauthorized'){
            // return  response()->json([
            //     'status'=>'Faild',
            //     'message'=>'Unauthorized token'
            //    ],401);
            return redirect('/userLogin');
        }else{
            $request->headers->set('email',$result->userEmail);
            $request->headers->set('id',$result->userID);
            return $next($request);
        }
    }
}
