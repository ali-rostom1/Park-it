<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingRequest;
use App\Models\Parking;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use function Pest\Laravel\json;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parkings = Parking::paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Parkings Retrieved successfully',
            'data' => $parkings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParkingRequest $request)
    {
        try{
            $parking = Parking::create($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Parking saved suscessfully',
                'data' => $parking,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error Saving Parking',
                'error' => $e->getMessage(),
            ],422);
        }   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $parking = Parking::find($id);
        if(!$parking){
            return response()->json([
                "status" => false,
                "message" => "Parking not found!",
            ],422);
        }
        return response()->json([
            'status' => true,
            'message' => 'Parking found Successfully',
            'data' => $parking
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParkingRequest $request, string $id)
    {
        try{
            $parking = Parking::find($id);
            $parking->update($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Parking updated successfully',
                'data' => $parking
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Parking failed to update'
            ],422);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $parking = Parking::find($id);
            $parking->destroy;
            return response()->json([
                'status' => true,
                'message' => 'Parking Deleted Successfully',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'error Deleting Parking',
                'error' => $e->getMessage(),
            ]);
        }
        
    }
    public function searchSpots($term)
    {
        $term = urldecode($term);
        $parkings = Parking::with('spots.reservations')->whereLike('location',"%$term%")->get();
        $filteredParkings = [];
        foreach($parkings as $parking)
        {
            $filteredSpots = $parking->spots->filter(function ($spot) {
                return $spot->reservations->isEmpty();
            });
            
            if ($filteredSpots->isNotEmpty()){
                $filteredParkings[] = [
                    'parking_name' => $parking->name,
                    'parking_spots_count' => count($parking->spots),
                    'available_spots' => $filteredSpots
                ];
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Successfully retrieved Spots available',
            'data' => $filteredParkings,
        ]);
    }
}
