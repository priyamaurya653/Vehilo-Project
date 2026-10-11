<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PartnerAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PARTNER REGISTER
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'mobile' => [
                    'required',
                    'string',
                    'max:20',
                    'unique:users,mobile',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],

                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],

                'partnership_type' => [
                    'required',
                    'string',
                ],

                'investment' => [
                    'required',
                    'string',
                ],

                'property' => [
                    'required',
                    'in:yes,no',
                ],

                'space' => [
                    'required',
                    'string',
                ],

                'experience' => [
                    'required',
                    'string',
                ],

                'fleet_size' => [
                    'required',
                    'string',
                ],

                'consent' => [
                    'required',
                    'accepted',
                ],

            ]
        );


        if ($validator->fails()) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Validation failed.',

                'errors' =>
                    $validator->errors(),

            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE USER + APPLICATION
        |--------------------------------------------------------------------------
        */

        $result = DB::transaction(function () use ($request) {

            $user = User::create([

                'name' =>
                    $request->name,

                'email' =>
                    $request->email,

                'mobile' =>
                    $request->mobile,

                'password' =>
                    Hash::make(
                        $request->password
                    ),

                'role' =>
                    'admin',

                'status' =>
                    true,

            ]);


            $application =
                PartnerApplication::create([

                    'user_id' =>
                        $user->id,

                    'name' =>
                        $request->name,

                    'mobile' =>
                        $request->mobile,

                    'email' =>
                        $request->email,

                    'partnership_type' =>
                        $request->partnership_type,

                    'investment' =>
                        $request->investment,

                    'property' =>
                        $request->property,

                    'space' =>
                        $request->space,

                    'experience' =>
                        $request->experience,

                    'fleet_size' =>
                        $request->fleet_size,

                    'consent' =>
                        true,

                    'status' =>
                        'approved',

                ]);


            return [

                'user' =>
                    $user,

                'application' =>
                    $application,

            ];
        });


        return response()->json([

            'success' => true,

            'message' =>
                'Partner account created successfully.',

            'user' => [

                'id' =>
                    $result['user']->id,

                'name' =>
                    $result['user']->name,

                'email' =>
                    $result['user']->email,

                'mobile' =>
                    $result['user']->mobile,

                'role' =>
                    $result['user']->role,

            ],

            'application' =>
                $result['application'],

            'login_url' =>
                url('/login'),

        ], 201);
    }


    /*
    |--------------------------------------------------------------------------
    | PARTNER ME
    |--------------------------------------------------------------------------
    */

    public function me(Request $request)
    {
        $user =
            $request->user()
                ->load('partnerApplication');


        if ($user->role !== 'admin') {

            return response()->json([

                'success' => false,

                'message' =>
                    'This account is not a partner account.',

            ], 403);
        }


        return response()->json([

            'success' => true,

            'data' =>
                $user,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | PARTNER LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $token =
            $request->user()
                ->currentAccessToken();


        if ($token) {

            $token->delete();

        }


        return response()->json([

            'success' => true,

            'message' =>
                'Partner logout successful.',

        ]);
    }
}