<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class WeatherEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests
     * - The weather endpoint cannot be accessed by an anonymous user
     * - The weather endpoint can be accessed by logged in user
     * - The weather endpoint returns an error if no location is provided
     * - The weather endpoint returns the specified data
     */

    /**
     * @test
     */
    public function weather_endpoint_cannot_be_accessed_by_anonymous_user()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/get-weather');

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function weather_endpoint_can_be_accessed_by_logged_in_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/get-weather?search=London');

        $response->assertOk();
    }

    /**
     * @test
     */
    public function weather_endpoint_returns_error_if_no_search_provided()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/get-weather');
        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('search');
    }

    /**
     * @test
     */
    public function weather_endpoint_returns_specified_data()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/get-weather?search=London');

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'data' => [
                    'temp_c',
                    'feelslike_c',
                    'condition' => [
                        "text",
                        "icon",
                        "code",
                    ],
                    'wind_dir',
                    'wind_mph',
                    'uv',
                ],
            ]
        );
    }
}
