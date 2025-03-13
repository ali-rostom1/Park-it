<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function __invoke()
    {
        try{
            $totalParkings = DB::table('parkings')->count();
            $totalSpots = DB::table('spots')->count();
            $totalReservations = DB::table('reservations')->count();
            $totalUsers = DB::table('users')->count();
            return response()->json([
                'status' => true,
                'message' => 'Successfully Retrieved statistics',
                'data' => [
                    'total_parkings' => $totalParkings,
                    'total_spots' => $totalSpots,
                    'total_reservations' => $totalReservations,
                    'total_users' => $totalUsers,
                ],
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Encouterd an error retrieving statistics',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
