<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forget' , 'reset']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);

        }else{
            try {
                $user = new User;
                $user->name  = $request->name;
                $user->email  = $request->email;
                $user->password  = Hash::make($request->password);
                $user->remember_token  = Str::random(60);
                $user->save();
                return response()->json([
                    'response' => Response::HTTP_CREATED,
                    'success' => true,
                    'message' => 'Register successfully.',
                    'data' => $request->all()
                ], Response::HTTP_CREATED);
                
            } catch (QueryException $e) {
                return response()->json([
                    'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'success' => false,
                    'errors' => $e->getMessage(),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'response' => Response::HTTP_UNAUTHORIZED,
                'success' => false,
                'message' => 'Unauthorized',
                'data' => [],
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function forget(Request $request ){
        $cek = User::where('email', $request->email)->first();
        if($cek == null){
            return response()->json([
                'response' => Response::HTTP_NOT_ACCEPTABLE,
                'success' => false,
                'message' => 'email is not registered',
                'data' => [],
            ], Response::HTTP_NOT_ACCEPTABLE);
        }else{
            try {
                $token = Str::random(32);
                DB::table('password_resets')->insert([
                    'email' => $request->email, 
                    'token' => $token, 
                ]); 
                Mail::send('forgetPassword', ['token' => $token], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Reset Password');
                });
                return response()->json([
                    'response' => Response::HTTP_OK,
                    'success' => true,
                    'message' => 'email sent successfully',
                    'data' => [],
                ], Response::HTTP_OK);
                
            } catch (QueryException $e) {
                return response()->json([
                    'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'success' => false,
                    'message' => $e->getMessage(),
                    'data' => []
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'response' => Response::HTTP_OK,
            'success' => true,
            'message' => 'Successfully logged out',
            'data' => [],
        ], Response::HTTP_OK);    
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'response' => Response::HTTP_OK,
            'success' => true,
            'message' => 'JWT Token refresh Successfully',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ], Response::HTTP_OK);
    }
}
