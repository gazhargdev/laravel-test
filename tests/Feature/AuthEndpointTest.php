<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class AuthEndpointTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Added just a single test here for proof of knowledge. More tests would be added for a real world application - GH
     */

    /**
     * @test
     */
    public function register_endpoint_user_registers_and_receives_token()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->postJson('/api/register', [
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ]);
        $response->assertOk();
        $response->assertJsonStructure([
            'authorisation' => [
                'token'
            ]
        ]);
    }

}
