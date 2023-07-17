<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class UserController extends Controller
{

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
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
                $result = Cloudinary::upload($imagePath,  ['folder' => 'user']);
                $imageUrl = $result->getSecurePath();
                $user = new User;
                $user->name  = $request->name;
                $user->email  = $request->email;
                $user->password  = Hash::make($request->password);
                $user->remember_token  = Str::random(60);
                $user->photo  = $imageUrl;
                $respons = $user->save();
                return response()->json([
                    'response' => Response::HTTP_OK,
                    'success' => true,
                    'message' => 'Create user',
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

    public function read()
    {
        try {
            $respons = User::all();
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Read all user',
                'data' => UserResource::collection($respons)
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

    public function update($id, Request $request)
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
                    $user = User::findOrFail($id);
                    $user->name  = $request->name;
                    $user->email  = $request->email;
                    $respons = $user->save();
                    return response()->json([
                        'response' => Response::HTTP_OK,
                        'success' => true,
                        'message' => 'update user without photo by id ' . $id,
                        'data' => []
                    ], Response::HTTP_OK);
                }else{
                    $imagePath = $request->file('photo')->getRealPath();
                    $result = Cloudinary::upload($imagePath,  ['folder' => 'user']);
                    $imageUrl = $result->getSecurePath();
                    $user =  User::findOrFail($id);;
                    $user->name  = $request->name;
                    $user->email  = $request->email;
                    $user->photo  = $imageUrl;
                    $respons = $user->save();
                    return response()->json([
                        'response' => Response::HTTP_OK,
                        'success' => true,
                        'message' => 'update user with photo by id ' . $id,
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

    public function delete($id)
    {
        try {
            User::destroy($id);
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Delete user by id ' . $id,
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

    public function search(Request $request){
        try {
            $keyword = $request->input('keyword');
            $respons = User::where('name', 'like', "%$keyword%")->get();
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Read user like '.$keyword,
                'data' => UserResource::collection($respons)
            ], Response::HTTP_OK
        );
            
        } catch (QueryException $e) {
            return response()->json([

                'response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []

            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function paginate(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $respons = User::paginate($perPage);
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Read user with pagination page ' . $request->page,
                'data' => UserResource::collection($respons)
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
