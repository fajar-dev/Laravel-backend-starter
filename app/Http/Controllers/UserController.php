<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function read(){
        try {
            $respons = User::all();
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Fetch all user',
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

    public function delete($id){
        try {
            User::destroy($id);
            return response()->json([
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Deleted user by id ' . $id,
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
