<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json([

                    'response' => Response::HTTP_UNAUTHORIZED,
                    'success' => false,
                    'message' => 'Token is Invalid',

                ], Response::HTTP_UNAUTHORIZED);
            }else if ($e instanceof TokenExpiredException){
                return response()->json([
                    
                    'response' => Response::HTTP_UNAUTHORIZED,
                    'success' => false,
                    'message' => 'Token is Expired',

                ], Response::HTTP_UNAUTHORIZED);
            }else{
                return response()->json([
                    
                    'response' => Response::HTTP_UNAUTHORIZED,
                    'success' => false,
                    'message' => 'Authorization Token not found',

                ], Response::HTTP_UNAUTHORIZED);
            }
        }
        return $next($request);
    }
}
