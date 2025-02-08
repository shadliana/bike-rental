<?php

namespace App\Observers;

use App\Models\Reservation;
use App\Models\Bike;
use Illuminate\Support\Facades\Log;

class ReservationObserver
{

    public function created(Reservation $reservation)
    {
        $bike = Bike::find($reservation->bike_id);
        if ($bike) {
            $bike->update(['status' => 'reserved']);
        }

    }

    public function deleted(Reservation $reservation)
    {
        $bike = Bike::find($reservation->bike_id);
        if ($bike) {
            $hasReservations = Reservation::where('bike_id', $bike->id)->exists();
            if (!$hasReservations) {
                $bike->update(['status' => 'available']);
            }
        }
    }

}


