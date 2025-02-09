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
                // بررسی تداخل برای تاریخ شروع و تاریخ پایان
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date])
                    // بررسی تداخل در صورتی که تاریخ شروع رزرو در بازه تاریخ شروع و پایان دیگر قرار گیرد
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query->where('start_date', '<=', $start_date)
                            ->where('end_date', '>=', $end_date);
                    });
            })
            ->exists();  // این متد فقط بررسی می‌کند که آیا چنین تداخلی وجود دارد یا نه
    }

}
