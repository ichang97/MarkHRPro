<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Modules\LineAuth;

use App\Models\User;

use Auth;
use stdClass;

class LineAuthController extends Controller
{
    public function test(){
        $line = new LineAuth;

        return $line->test();
    }

    public function auth(){
        $auth_url = 'https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=' . config('app.line_channel_id')
                        . '&redirect_uri=' . config('app.line_callback_url')
                        . '&state=' . (Str::random(7) . microtime())
                        . '&scope=profile%20openid%20email';
        return view('line-auth.index', compact('auth_url'));
    }

    public function authCallback(Request $request){
        if($request){

            if(isset($request->code)){
                $auth = Auth::user();

                if($auth){
                    $user = User::find($auth->id);

                    $user->line_auth_token = $request->code;
                    $user->update();

                    $token = $this->tokenCallback($request->code);

                    $token_result = new stdClass;
                    $token_result->access_token = $token['access_token'];
                    $token_result->expired_at = $token['expires_in'];
                    $token_result->refresh_token = $token['refresh_token'];

                    if($token_result){
                        $user->line_access_token = $token_result->access_token;
                        $user->line_access_token_expired_at = date('Y-m-d H:i:s', strtotime('+ ' . $token_result->expired_at . ' SECONDS'));
                        $user->line_refresh_token = $token_result->refresh_token;
        
                        $user->update();

                        return redirect()->route('home');
                    }
                }else{
                    return response()->json('User not found.', 500);
                }
            }
            
        }else{
            return response()->json('Invalid request.', 500);
        }
    }

    public function tokenCallback($auth){
        if($auth){
            $line = new LineAuth;

            $token = $line->getAccessToken($auth);

            if($token){
                return $token;

            }else{
                return response()->json('get token error.' . $token, 500);
            }
        }else{
            return response()->json('User not found.', 500);
        }
    }
}
