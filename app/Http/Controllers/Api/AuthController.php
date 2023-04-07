<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(SignupRequest $request) {

        $data = $request->validated();

        /** @var \App\Models\User $user */

        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        $user["seller"] = $user->sellers();
        $token = $user->createToken('main')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token,
            'success' => true
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response([
                'error' => 'The Provided credentials are not correct',
                'success' => false
            ], 422);
        }
        $user = Auth::user();
        $user["seller"] = $user->sellers();
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
            'success' => true
        ]);
    }

    public function logout(Request $request)
    {
        try {
            /** @var User $user */
            $user = Auth::user();
            // Revoke the token that was used to authenticate the current request...
            $user->currentAccessToken()->delete();

            return response([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response([
                'error' => $e,
                'success' => false
            ], 404);
        }
    }
    public function me(Request $request)
    {
        try {
            // Xử lý logic của bạn ở đây
            $user = Auth::user();
            $user["seller"] = $user->sellers ?? null;
            return response(
                [
                    'user' => $user,
                    'success' => true
                ]
            );
        } catch (\Exception $e) {
            // Xử lý lỗi của bạn ở đây
            return response()->json([
                'error' => $e->getMessage(),
                'success' => false
            ], 401);
        }
    }

}
