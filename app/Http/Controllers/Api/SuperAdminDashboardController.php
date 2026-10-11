<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | AUTH CHECK
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE CHECK
        |--------------------------------------------------------------------------
        */

        $role = strtolower(trim($user->role ?? ''));

        if (
            $role !== 'superadmin' &&
            $role !== 'super_admin' &&
            $role !== 'super-admin'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD DATA
        |--------------------------------------------------------------------------
        |
        | Abhi basic values 0 hain.
        | Baad mein actual User / Partner / Vehicle / Booking
        | tables se counts laga sakte hain.
        |
        */

        return response()->json([
            'success' => true,

            'message' => 'Super Admin dashboard data.',

            'data' => [

                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'role' => 'superadmin',
                    'status' => (bool) $user->status,
                ],

                'stats' => [

                    'total_users' => 0,

                    'total_partners' => 0,

                    'total_vehicles' => 0,

                    'total_bookings' => 0,

                ],

            ],

        ], 200);
    }
}