<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helper\JWTtoken;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;
//use App\Mail\MailService;
use Illuminate\View\View;


class UserController extends Controller
{
    //Page routes
    function HomePage(){
        return 'This is home page';
    }
    function LoginPage():view{
       return view('pages.auth.login-page');
    }
    
    function RegistrationPage():view{
        return view('pages.auth.registration-page');
     }
     function SendOtpPage():view{
        return view('pages.auth.send-otp-page');
     }
     function VerifyOtpPage():view{
        return view('pages.auth.verify-otp-page');
     }
     function ResetPasswordPage():view{
        return view('pages.auth.reset-pass-page');
     }


     function ProfilePage():View{
      return view('pages.dashboard.profile-page');
  }


     //Page routes

     function UserRegistration(Request $request){
      try {

         User::create([
            'firstName'=> $request->input('firstName'),
            'lastName'=>$request->input('lastName'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'password'=>$request->input('password')
          ]);

         return  response()->json([
           'status'=>'Success',
           'messege'=>'User registration Success'
          ],200);
       
       } catch (Exception $e) {
       
         return  response()->json([
            'status'=>'faild',
            'messege'=>$e->getMessage()
           ],200);
       }
    
           
     }


     function userLogin(Request $request){
       $count=User::where('email', '=' ,$request->input('email'))
             ->where('password', '=' ,$request->input('password'))
             ->select('id')->first();

       if($count!==null){
         $token=JWTtoken::CreateToken($request->input('email'),$count->id);
         return  response()->json([
            'status'=>'Successful',
            'messege'=>'User login successful',
           ],200)->cookie( 'token',$token,60*24*30,);
       } else{
         return  response()->json([
            'status'=>'faild',
            'messege'=>'User Unauthorized'
           ],200);
       }     
     }

     function SendOTPCode(Request $request){ 
           // dd($request->all());
            $email=$request->input('email');
            $otp = rand(1000,9999);
            $count = User::where('email','=',$email)->count();

            if($count==1){
              Mail::to($email)->send(new OTPMail($otp));
              User::where('email','=',$email)->update(['otp'=>$otp]);
              return  response()->json([
               'status'=>'Success',
               'messege'=>'4 digit otp code has been sent your email'
              ],200);
            }else{
               return  response()->json([
                  'status'=>'faild',
                  'messege'=>'Unauthorized'
                 ],200);
            }
     }
     
     function VerifyOTP(Request $request){
        $email=$request->input('email');
        $otp=$request->input('otp');

        $count=User::where('email','=',$email)->where('otp','=',$otp)->count();

        if($count==1){
           
         //Database OTP update
         User::where('email','=',$email)->update(['otp'=>'0']);
         //Password reset token issues
         $token=JWTtoken::CreateTokenForSetPassword($request->input('email'));
         return  response()->json([
            'status'=>'Successful',
            'messege'=>'OTP verification successfull',
           ],200)->cookie('token',$token,60*24*30);

        }else{
         return  response()->json([
            'status'=>'faild',
            'messege'=>'Opt varification faild'
           ],401);
        }
     }

     function ResetPassword(Request $request){
      try{
         $email=$request->header('email');
         $password=$request->input('password');
         User::where('email','=',$email)->update(['password'=>$password]);
         return  response()->json([
            'status'=>'Successful',
            'messege'=>'Request successfull'
           ],200);
      }catch (Exception $e) {
         return  response()->json([
            'status'=>'faild',
            'messege'=>$e->getMessage()
           ],200);
       }
     }
     function userLogout(){
      return redirect('/userLogin')->cookie('token','',-1);
     }


     function UserProfile(Request $request){
      $email=$request->header('email');
      $user = User::where('email','=',$email)->first();
      return response()->json([
          'status'=>'success',
          'message'=>'Request Successful',
          'data'=>$user
      ],200);
     }

     function UpdateProfile(Request $request){
      try{
         $email=$request->header('email');
         $firstName=$request->input('firstName');
         $lastName=$request->input('lastName');
         $mobile=$request->input('mobile');
         $password=$request->input('password');
         User::where('email','=',$email)->update([
           'firstName'=>$firstName,
           'lastName'=>$lastName,
           'mobile'=>$mobile,
           'password'=>$password
         ]);
         return response()->json([
           'status'=>'success',
           'messege'=>'Request Successful'
         ],200);
      }catch(Exception $exception){
         return response()->json([
            'status'=>'faild',
            'messege'=>'Something went wrong'
          ],200);
      }
     }
}
