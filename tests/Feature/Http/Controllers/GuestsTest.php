<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\User;
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
        // Add Confirmation password
        $this->applicant_guest["password_confirmation"]  = $this->applicant_guest["password"];

        $this->recruiter_guest = factory('App\Recruiter')->raw();
        // Add Confirmation password
        $this->recruiter_guest["password_confirmation"]  = $this->recruiter_guest["password"];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_can_get_jobs(){
        $response = $this->json('GET', '/api/guest/jobs');
        $structure = [
            'data' => [
                '*' => [
                  'id',
                  'title',
                  'description',
                  'accept_interviews_from',
                  'accept_interviews_until',
                  'interview_duration',
                  'recruiter_id'
            ]
            ]
        ];
        $response->assertJsonStructure($structure);

        $response->assertStatus(200);
    }

    public function test_guest_can_register_as_applicant()
    {
        $response = $this->post('api/register', $this->applicant_guest);
        // Have authentication but not as applicant or recruiter
        $this->assertAuthenticated();
        //$response->assertStatus(201);
    }

    public function test_guest_can_register_as_recruiter()
    {
        $response = $this->post('api/register', $this->recruiter_guest);
        // Have authentication but not as applicant or recruiter
        $this->assertAuthenticated();
        //$response->assertStatus(201);
    }

    public function test_guest_cant_register_as_applicant_with_existing_email()
    {
        $this->post('api/register', $this->applicant_guest);
        $response = $this->post('api/register', $this->applicant_guest);

        $response->assertStatus(302);
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
        /*
        $applicant = factory(Applicant::class)->create();
        Passport::actingAs($applicant, [], 'applicant');

        //$response = $this->post('api/logout');
        
        $response = $this->json('POST', 'api/logout');
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($applicant, $guard = null);
        */
    }

    public function test_recruiter_can_logout()
    {
        /*
        $recruiter = factory(Recruiter::class)->create();
        Passport::actingAs($recruiter, [], 'recruiter');

        $response = $this->post('api/logout', [
            'email' => $recruiter->email,
            'password' => $recruiter->passwords,
        ]);
        $response->assertStatus(204);
        */
    }
}
