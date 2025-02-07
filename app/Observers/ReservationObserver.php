<?php

namespace App\Observers;

use App\Models\Reservation;
use App\Models\Bike;
use Illuminate\Support\Facades\Log;

class ReservationObserver
{
    /**
     * هنگامی که یک رزرو جدید ایجاد می‌شود، وضعیت دوچرخه را به `reserved` تغییر می‌دهد.
     */
    public function created(Reservation $reservation)
    {
        $bike = Bike::find($reservation->bike_id);
        if ($bike) {
            $bike->update(['status' => 'reserved']);
        }

    }

    /**
     * هنگامی که یک رزرو حذف شد، وضعیت دوچرخه را به `available` تغییر می‌دهد.
     */
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


