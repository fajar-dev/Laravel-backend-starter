<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Routing\Controller;

class AccountController extends Controller
{
    public function update($id, Request $request)
    {    
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
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
                $user = User::findOrFail($id);
                $user->name  = $request->name;
                $user->email  = $request->email;
                $respons = $user->save();
                return response()->json([
                    'response' => Response::HTTP_OK,
                    'success' => true,
                    'message' => 'User account update successfully.',
                    'data' => $respons
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

    public function photo($id, Request $request)
    {    
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
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
                $imagePath = $request->file('photo')->getRealPath();
                $result = Cloudinary::upload($imagePath,  ['folder' => 'bc/user']);
                $imageUrl = $result->getSecurePath();
                $user = User::findOrFail($id);
                $user->photo  = $imageUrl;
                $respons = $user->save();
        
                return response()->json([
                    'response' => Response::HTTP_OK,
                    'success' => true,
                    'message' => 'User account update successfully.',
                    'data' => $respons
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
