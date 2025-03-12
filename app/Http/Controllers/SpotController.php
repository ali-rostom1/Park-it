<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingRequest;
use App\Http\Requests\SpotRequest;
use App\Models\Spot;
use Exception;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $spots = Spot::paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Spots retrieved successfully',
                'data' => $spots,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error trying to retrieve all spots',
                'error' => $e->getMessage(),
            ],422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpotRequest $request)
    {
        try{
            $spot = Spot::create($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Saved spot successfully',
                'data' => $spot,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error saving spot',
                'error' => $e->getMessage(),
            ],422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $spot = Spot::find($id);
            return response()->json([
                'status' => true,
                'message' => 'Retrived spot successfully',
                'data' => $spot,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'error retrieving spot',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpotRequest $request, string $id)
    {
        try{
            $spot = Spot::find($id);
            $spot->update($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Updated spot successfully',
                'data' => $spot,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error updating spot',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $spot = Spot::find($id);
            $spot->destroy;
            return response()->json([
                'status' => true,
                'message' => 'Spot Deleted Successfully',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'error Deleting spot',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
