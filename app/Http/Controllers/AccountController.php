<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AccountController extends Controller
{
    public function update(Request $request)
    {    
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else{
            try {
                if(empty($request->photo)){
                    $user = User::findOrFail(Auth::user()->id);
                    $user->name  = $request->name;
                    $user->email  = $request->email;
                    $respons = $user->save();
                    return response()->json([
                        'response' => Response::HTTP_OK,
                        'success' => true,
                        'message' => 'User account update without photo successfully.',
                        'data' => $respons
                    ], Response::HTTP_OK);
                }else{
                    $imagePath = $request->file('photo')->getRealPath();
                    $result = Cloudinary::upload($imagePath,  ['folder' => 'user']);
                    $imageUrl = $result->getSecurePath();
                    $user = User::findOrFail(Auth::user()->id);
                    $user->name  = $request->name;
                    $user->email  = $request->email;
                    $user->photo  = $imageUrl;
                    $user->save();
            
                    return response()->json([
                        'response' => Response::HTTP_OK,
                        'success' => true,
                        'message' => 'User account update with photo successfully',
                        'data' => []
                    ], Response::HTTP_OK);
                }
                
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

    public function password_change(Request $request)
    {    
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'success' => false,
                'message' => $validator->errors(),
                'data' => []
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }else{
            try {
                    $user = User::findOrFail(Auth::user()->id);
                    $user->password  = Hash::make($request->password);
                    $user->save();
                    return response()->json([
                        'response' => Response::HTTP_OK,
                        'success' => true,
                        'message' => 'Change password successfully',
                        'data' => []
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
}

