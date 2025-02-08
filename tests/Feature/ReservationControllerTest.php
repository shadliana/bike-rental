<?php

namespace Tests\Feature;

use App\Models\Bike;
use App\Models\Reservation;
use App\Models\User;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{

    /** @test */
    public function test_user_can_view_their_reservations()
    {
        // ایجاد یک کاربر و احراز هویت آن
        $user = User::factory()->create();
        $this->actingAs($user);

        // ایجاد رزروهایی برای کاربر
        Reservation::factory()->count(3)->create(['user_id' => $user->id]);

        // ارسال درخواست GET به متد index
        $response = $this->getJson('/api/reservations');

        // بررسی وضعیت پاسخ و تعداد رزروها
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }



    /** @test */
    public function test_user_can_create_a_reservation()
    {
        // ایجاد یک کاربر و احراز هویت آن
        $user = User::factory()->create();
        $this->actingAs($user);

        // ایجاد دوچرخه‌ای برای رزرو
        $bike = Bike::factory()->create();

        // ارسال درخواست POST برای ایجاد رزرو
        $response = $this->postJson('/api/reservations', [
            'bike_id' => $bike->id,
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
        ]);

        // بررسی وضعیت پاسخ و داده‌های رزرو
        $response->assertStatus(201)
            ->assertJson([
                'bike_id' => $bike->id,
                'start_date' => now()->addDay()->toDateString(),
                'end_date' => now()->addDays(2)->toDateString(),
            ]);
    }


    /** @test */
    public function test_user_can_delete_a_reservation()
    {
        // ایجاد یک کاربر و احراز هویت آن
        $user = User::factory()->create();
        $this->actingAs($user);

        // ایجاد رزروی برای کاربر
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);

        // ارسال درخواست DELETE برای حذف رزرو
        $response = $this->deleteJson('/api/reservations/' . $reservation->id);

        // بررسی وضعیت پاسخ و عدم وجود رزرو در پایگاه داده
        $response->assertStatus(200);
        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }

}
