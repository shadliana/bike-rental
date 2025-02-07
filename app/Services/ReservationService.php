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
    public function checkReservationConflict(int $bikeId, string $startDate, string $endDate): bool
    {
        $existingReservations = Reservation::where('bike_id', $bikeId)
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        return !$existingReservations;
    }
}
