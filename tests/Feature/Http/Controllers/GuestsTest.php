<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\User;


class GuestsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_can_register_as_applicant()
    {
        $user = factory('App\Applicant')->raw();

        $response = $this->post('api/register', $user);
        
        $response->assertStatus(201);
    }

    public function test_guest_can_register_as_recruiter()
    {
        $user = factory('App\Recruiter')->raw();

        $response = $this->post('api/register', $user);
        
        $response->assertStatus(201);
    }
}
