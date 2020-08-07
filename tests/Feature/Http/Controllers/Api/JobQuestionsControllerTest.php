<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Applicant;
use App\Interview;
use App\Job;
use Laravel\Passport\Passport;

class JobQuestionsControllerTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_cant_get_job_questions()
    {
        $response = $this->json('GET', '/api/applicant/jobs/2/questions');

        $response->assertStatus(401);

    }

    public function test_applicant_can_get_job_questions()
    {

        $user = factory(Applicant::class)->create();
        $job = factory(Job::class)->create();
        // $interview = Interview::create(['applicant_id' => $user->getKey()]);
        $interview = $job->interviews()->create(['applicant_id' => $user->getKey() ]);
        $response = Passport::actingAs($user);
        $response = $this->json('GET', route('applicantarea.jobs.apply', ['job' => $job->getRouteKey()]));

        $response->assertStatus(200);
    }
    
}
