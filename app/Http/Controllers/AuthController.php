<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if (auth()->check()) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Already authenticated',
                'data' => []
            ], 403);
        }

        $credentials = request(['username', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Unauthorized',
                'data' => []
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['status' => 'Success' ,'message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $dataUser = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'Success',
            'message' => 'Login Success!',
            'data' => [
                'token' => $token,
                'admin' => [
                    'id' => $dataUser->id,
                    'name' => $dataUser->name,
                    'username' => $dataUser->username,
                    'phone' => $dataUser->phone,
                    'email' => $dataUser->email
                ]
            ]
        ]);
    }
}