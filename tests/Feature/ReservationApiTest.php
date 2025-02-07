<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class ReservationApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_make_a_reservation()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $bike = Bike::factory()->create();

        $response = $this->postJson('/api/reservations', [
            'bike_id' => $bike->id,
            'date' => now()->toDateString(),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'user_id', 'bike_id', 'date']);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_make_a_reservation()
    {
        $bike = Bike::factory()->create();

        $response = $this->postJson('/api/reservations', [
            'bike_id' => $bike->id,
            'date' => now()->toDateString(),
        ]);

        $response->assertStatus(401); // Unauthorized
    }
}
