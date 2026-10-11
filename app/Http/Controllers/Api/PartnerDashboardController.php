<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user =
            $request->user()
                ->load('partnerApplication');


        if ($user->role !== 'admin') {

            return response()->json([

                'success' => false,

                'message' =>
                    'Unauthorized.',

            ], 403);
        }


        return response()->json([

            'success' => true,

            'message' =>
                'Partner dashboard data.',

            'data' => [

                'user' => [

                    'id' =>
                        $user->id,

                    'name' =>
                        $user->name,

                    'email' =>
                        $user->email,

                    'mobile' =>
                        $user->mobile,

                    'role' =>
                        $user->role,

                ],

                'application' =>
                    $user->partnerApplication,

                'stats' => [

                    'total_vehicles' => 0,

                    'total_bookings' => 0,

                    'total_earnings' => 0,

                    'active_vehicles' => 0,

                ],

            ],

        ]);
    }
}