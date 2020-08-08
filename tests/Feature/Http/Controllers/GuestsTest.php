<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Applicant;
use App\Recruiter;


class GuestsTest extends TestCase
{
    private $applicant_guest = null;
    private $recruiter_guest = null;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->applicant_guest = factory('App\Applicant')->raw();
        $this->recruiter_guest = factory('App\Recruiter')->raw();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_can_register_as_applicant()
    {
        // Add Confirmation password
        $this->applicant_guest["password_confirmation"]  = $this->applicant_guest["password"];

        $response = $this->post('api/register', $this->applicant_guest);
        $response->assertStatus(201);
    }

    public function test_guest_can_register_as_recruiter()
    {
        // Add Confirmation password
        $this->recruiter_guest["password_confirmation"]  = $this->recruiter_guest["password"];

        $response = $this->post('api/register', $this->recruiter_guest);
        $response->assertStatus(201);
    }

    public function test_guest_can_login_as_applicant()
    {
        $applicant = factory(Applicant::class)->create([
            'password' => bcrypt($password = '12345678'),
        ]);

        $response = $this->post('api/login', [
            'email' => $applicant->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($applicant);
        $response->assertStatus(200);
    }

    public function test_guest_can_login_as_recruiter()
    {
        $recruiter = factory(Recruiter::class)->create([
            'password' => bcrypt($password = '12345678'),
        ]);

        $response = $this->post('api/login', [
            'email' => $recruiter->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($recruiter);
        $response->assertStatus(200);
    }

    public function test_applicant_can_logout()
    {
        //
    }

    public function test_recruiter_can_logout()
    {
        //
    }
}
