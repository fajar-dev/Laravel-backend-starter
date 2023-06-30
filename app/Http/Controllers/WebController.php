<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    public function resetForm($token) { 
        $cekToken = DB::table('password_resets')->where('token', '=', $token)->first();
        if($cekToken){
            return view('web.reset', ['token' => $token]);
        }
        else{
            return 'Invalid Token';
        }
    }

    /**
      * Write code on Method
      *
      * @return response()
      */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
 
        $updatePassword = DB::table('password_resets')
                            ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                            ])
                            ->first();
 
        if(!$updatePassword){
            return 'Invalid Token';
        }
 
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')
            ->where(['email'=> $request->email])->delete();
 
        return 'Success';
    }

}
