<?php

namespace App\Services;

use App\Models\Reservation;

class ReservationService
{
    /**
     * @param int $bikeId
     * @param string $startDate
     * @param string $endDate
     * @return bool
     */
    public function checkReservationConflict($bike_id, $start_date, $end_date)
    {
        return Reservation::where('bike_id', $bike_id)
            ->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date])
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query->where('start_date', '<=', $start_date)
                            ->where('end_date', '>=', $end_date);
                    });
            })
            ->exists();
    }

}
