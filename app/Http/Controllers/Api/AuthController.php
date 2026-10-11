<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|string',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | FIND USER
        |--------------------------------------------------------------------------
        */

        $user = User::where(
            'email',
            $request->email
        )->first();


        /*
        |--------------------------------------------------------------------------
        | INVALID LOGIN
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !Hash::check(
                $request->password,
                $user->password
            )
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | ACCOUNT STATUS
        |--------------------------------------------------------------------------
        */

        if (!$user->status) {

            return response()->json([
                'success' => false,
                'message' => 'Your account is inactive.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | NORMALIZE ROLE
        |--------------------------------------------------------------------------
        */

        $role = strtolower(
            trim($user->role ?? '')
        );


        if ($role === 'super_admin') {
            $role = 'superadmin';
        }


        if ($role === 'super-admin') {
            $role = 'superadmin';
        }


        /*
        |--------------------------------------------------------------------------
        | ALLOWED ROLES
        |--------------------------------------------------------------------------
        */

        $allowedRoles = [
            'superadmin',
            'admin',
            'user',
        ];


        if (!in_array($role, $allowedRoles)) {

            return response()->json([
                'success' => false,
                'message' => 'Your account role is not allowed to login.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE NORMALIZED ROLE
        |--------------------------------------------------------------------------
        */

        if ($user->role !== $role) {

            $user->role = $role;

            $user->save();
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE OLD TOKENS
        |--------------------------------------------------------------------------
        */

        $user->tokens()->delete();


        /*
        |--------------------------------------------------------------------------
        | CREATE NEW TOKEN
        |--------------------------------------------------------------------------
        */

        $token = $user
            ->createToken('login-token')
            ->plainTextToken;


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        $redirect = '/';


        if ($role === 'superadmin') {

            $redirect =
                '/superadmin/dashboard';

        } elseif ($role === 'admin') {

            $redirect =
                '/partner/dashboard';

        } elseif ($role === 'user') {

            $redirect =
                '/user/dashboard';
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => true,

            'message' => 'Login successful.',

            'token_type' => 'Bearer',

            'access_token' => $token,

            'redirect' => $redirect,

            'user' => [

                'id' => $user->id,

                'name' => $user->name,

                'email' => $user->email,

                'mobile' => $user->mobile,

                'role' => $role,

                'status' => (bool) $user->status,

            ],

        ], 200);
    }


    /*
    |--------------------------------------------------------------------------
    | ME
    |--------------------------------------------------------------------------
    */

    public function me(Request $request)
    {
        return response()->json([

            'success' => true,

            'user' => $request->user(),

        ], 200);
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $user = $request->user();


        if ($user) {

            $currentToken =
                $user->currentAccessToken();


            if ($currentToken) {

                $currentToken->delete();
            }
        }


        return response()->json([

            'success' => true,

            'message' => 'Logout successful.',

        ], 200);
    }
}