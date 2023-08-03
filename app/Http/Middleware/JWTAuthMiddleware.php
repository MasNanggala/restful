<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if ($request->is('api/login')){
        return $next($request);
       }

       $token = $request->bearerToken();
       if(isset($token)) {
       $key = env('JWT_KEY', 'iniRahasiaDon9');

       try{
        $decode = JWT::decode($token, new Key($key, 'HS256'));
        if($request-> is('api/me')){
            return response()->json($decode);
        }
        return $next($request);
       }
       catch (\Exception $ex) {
        return response()->json([
            "status" => 401,
            "success" => false,
            "message" => $ex->getMessage()
        ], 401);
    }
       } 
       else {
        return response()->json([
            "status" => 401,
            "success" => false,
            "message" => 'Token tidak ditemukan!'
        ], 401);
       }
    }
}