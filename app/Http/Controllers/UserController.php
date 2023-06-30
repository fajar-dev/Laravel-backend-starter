<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Http\Resources\RequestsResource;

class UserController extends Controller
{
    public function user(){
        try {
            $respons = DB::table('users')
            ->get();
            return response()->json([

                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Fetch all',
                'data' => RequestsResource::collection($respons)

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
