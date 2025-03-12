<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $reservations = Reservation::paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Retrieved Reservations Successfully',
                'data' => $reservations,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve reservations',
                'error' => $e->getMessage(), 
            ],422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
        try{
            $request->validated();
            $reservation = Reservation::where('spot_id',$request->spot_id)
            ->where('start_date', '<=', $request->end_date)
            ->where('end_date', '>=', $request->start_date)
            ->exists();
            if(!$reservation){
                $reservation = Reservation::create($request->all());
                $reservation->spot()->update(["is_available" => false]);
                return response()->json([
                    'status' => true,
                    'message' => 'Stored reservation successfully',
                    'data' => $reservation,
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Reservation dates full',  
                'data' => $reservation,
            ]); 
            
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error storing reservation',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $reservation = Reservation::find($id);
            return response()->json([
                'status' => true,
                'message' => 'Successfully retrieved reservation',
                'data' => $reservation,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve reservation',
                'error' => $e->getMessage(),
            ],422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationRequest $request, string $id)
    {
        try{
            $reservation = Reservation::find($id);
            $reservation->update($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Successfully updated reservation',
                'data' => $reservation,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error updating reservation',
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
            $reservation = Reservation::find($id);
            $reservation->destroy();
            return response()->json([
                'status' => true,
                'message' => 'Successfully delete the reservation',
                'data' => $reservation,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error deleting the reservation',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
