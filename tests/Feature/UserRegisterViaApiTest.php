<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegisterViaApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // arrange
        $faker = \Faker\Factory::create();
        $password = $faker->password(8);

        $data = [
            'email' => $faker->email,
            'name' => $faker->name,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        // act
        $response = $this->post('/api/v1/register', $data);

        // assert
        $response->assertStatus(200);
    }
}
