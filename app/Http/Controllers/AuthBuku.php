<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Firebase\JWT\JWT;
// use App\Http\Controllers\Controller;

class AuthBuku extends BaseController{
    public function login(){
        $email = request()->get('username');
        $password = request()->get('password');

        $user = DB::table('user')->where('username', $email)
                    -> whereRaw('password = sha1(?)', $password)
                    ->first();

        if ($user){
            $token = $this->createToken($email);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Login berhasil',
                'access_token' => $token,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Email atau password salah, silahkan coba lagi!',
            ], 401);
        }
    }

    private function createToken($email){
        $appKey = env('JWT_KEY');
        $iat = time();
        $payload = [
            'iss' => 'http://localhost:8000',
            'aud' => 'http://localhost:8000',
            'iat' => $iat,
            'exp' => $iat + (60*60),
            'email' => $email
        ];

        $token = JWT::encode($payload, $appKey, 'HS256');
        return $token;
    }
}