<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::where('user_id', auth()->id())->get();
    }

    public function create(Request $request, ReservationService $reservationService)
    {

        $request->validate([
            'bike_id' => 'required|exists:bikes,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $isConflict = $reservationService->checkReservationConflict(
            $request->bike_id,
            $request->start_date,
            $request->end_date
        );

        if ($isConflict) {
            return response()->json(['message' => 'this bicycle has been reserved this dates'], 400);
        }

        return Reservation::create([
            'user_id' => auth()->id(),
            'bike_id' => $request->bike_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    }


    public function delete(Reservation $reservation)
    {
        return $reservation->delete();

    }
}

