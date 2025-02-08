<?php

namespace Tests\Feature;

use App\Models\Bike;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class BikeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_bikes()
    {
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $token = $response->json('access_token');
        Bike::factory()->count(3)->create();
        $response = $this->getJson('/api/bikes', [
            'Authorization' => 'Bearer ' . $token
        ]);
        $token = $response->json('access_token');
        $this->assertNotEmpty($token);
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }


    /** @test */
    public function only_admin_can_create_a_bike()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->postJson('/api/bikes', ['name' => 'Bike 1']);
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_create_a_bike()
    {

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $response = $this->postJson('/api/bikes', ['name' => 'Bike 1']);
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['id']);
    }

    /** @test */
    public function it_can_update_a_bike()
    {

        $bike = Bike::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->putJson('/api/bikes/' . $bike->id, ['name' => 'Updated Bike']);

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonFragment(['name' => 'Updated Bike']);
    }

    /** @test */
    public function it_can_delete_a_bike()
    {

        $bike = Bike::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->deleteJson('/api/bikes/' . $bike->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('bikes', ['id' => $bike->id]);
    }
}
