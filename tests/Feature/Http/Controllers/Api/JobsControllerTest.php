<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Applicant;
use App\Recruiter;
use App\Interview;
use App\Job;
use Laravel\Passport\Passport;

class JobsControllerTest extends TestCase
{
    private $applicant = null;
    private $recruiter = null;
    private $job = null;
    private $interview = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->applicant = factory(Applicant::class)->create();
        $this->recruiter = factory(Recruiter::class)->create();
        $this->job = factory(Job::class)->create();
        $this->interview = $this->job->interviews()->create(['applicant_id' => $this->applicant->getKey() ]);
        $this->job = factory(Job::class)->create();
        $this->interview = $this->job->interviews()->create(['applicant_id' => $this->applicant->getKey() ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_applicant_can_get_interviews_for_jobs_he_applied_on()
    {
        Passport::actingAs($this->applicant, [], 'applicant');
        $response = $this->get('api/applicant/interviews');
        //dd($response);

        $structure = [
            'data' => [
                '*' => [
                  'id',
                  'job' => [
                      "id",
                      "title",
                      "description",
                      "accept_interviews_from",
                      "accept_interviews_until",
                      "interview_duration",
                      "recruiter_id"
                    ],
            ]
            ]
        ];
        $response->assertJsonStructure($structure);

        $response->assertStatus(200);
    }
    
    public function test_applicant_may_not_be_applied_on_job_interview()
    {
        $applicant = factory(Applicant::class)->create();
        Passport::actingAs($applicant, [], 'applicant');
        $response = $this->get('api/applicant/interviews');

        $structure = [
            'data' => []
        ];
        $response->assertJsonStructure($structure);

        $response->assertStatus(200);
    }

    public function test_recruiter_can_add_new_job()
    {
        Passport::actingAs($this->recruiter, [], 'recruiter');
        $url = route('recruiterarea.jobs.store');
        $job = factory('App\Job')->raw();
        dd($job);
        //unset($job["recruiter_id"]);

        $response = $this->post($url, $job);
        
        $response->assertStatus(201);
    }
}
