<?php

namespace Tests\Feature;

use App\Models\Bike;
use App\Models\Reservation;
use App\Models\User;
use Tests\TestCase;
use App\Services\ReservationService;

class ReservationControllerTest extends TestCase
{

    /** @test */
    public function test_user_can_see_only_their_reservations()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $bike = Bike::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'bike_id' => $bike->id,
        ]);
        Reservation::factory()->create([
            'user_id' => $otherUser->id,
            'bike_id' => $bike->id,
        ]);

        $this->actingAs($user, 'api');

        $response = $this->getJson('/api/reservations');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment(['id' => $reservation->id]);
    }


    /** @test */
    public function test_user_can_create_a_reservation()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $bike = Bike::factory()->create();
        $isConflict = app(ReservationService::class)->checkReservationConflict(
            $bike->id,
            '2025-02-23',
            '2025-02-28'
        );

        if (!$isConflict) {
            $response = $this->postJson('/api/reservations', [
                'bike_id' => $bike->id,
                'start_date' => '2025-02-23',
                'end_date' => '2025-02-28',
            ]);

            $response->assertStatus(201)
                ->assertJson([
                    'bike_id' => $bike->id,
                    'start_date' => '2025-02-23',
                    'end_date' => '2025-02-28',
                ]);
        } else {
            $this->fail('Bike is already reserved during this period.');
        }
    }



    /** @test */
    public function test_user_can_delete_a_reservation()
    {
        $user = User::factory()->create();
        $this->actingAs($user,'api');
        $reservation = Reservation::factory()->create(['user_id' => $user->id]);
        $response = $this->deleteJson('/api/reservations/' . $reservation->id);
        $response->assertStatus(200);
        $this->assertSoftDeleted('reservations', ['id' => $reservation->id]);
    }

}
