<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

use StdClass;
use Auth;
use Hash;

class FBAuthController extends Controller
{
    use AuthenticatesUsers;

    public function test(){
        $fb = new FBAuth;

        return $fb->getFbAccount();
    }

    public function getFBData(Request $request){
        if($request){
            if($request->fb_email){
                $users = User::where('email', $request->fb_email)->first();

                if($users){
                    return response()->json('User is duplicate.', 500);
                }else{
                    $user                   = new User;
                    $user->firstname        = $request->fb_name;
                    $user->lastname         = '';
                    $user->email            = $request->fb_email;
                    $user->password         = Hash::make($request->fb_access_token);
                    $user->fb_access_token  = $request->fb_access_token;
                    $user->fb_user_id       = $request->fb_user_id;
                    $user->save();

                    //login auto
                    $login_data = [
                        'email' => $user->email,
                        'password' => $request->fb_access_token
                    ];

                    if(Auth::attempt($login_data)){
                        $request->session()->regenerate();
                        return response()->json('FB User register completed.', 200);
                    }
                }
                
            }else{
                return response()->json('GET FB EMAIL ERROR', 500);
            }
        }else{
            return response()->json('Error', 500);
        }
    }
}
