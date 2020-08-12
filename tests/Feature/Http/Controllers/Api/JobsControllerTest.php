<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Applicant;
use App\Recruiter;
use App\Interview;
use App\Job;
use App\Skill;
use App\Question;
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
        $this->question = factory(Question::class)->create();
        $this->job->questions()->attach($this->question);
    }

    public function test_applicant_can_get_interviews_for_jobs_he_applied_on()
    {
        Passport::actingAs($this->applicant, [], 'applicant');
        $response = $this->get('api/applicant/interviews');

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

        $response->assertJson(['data' => []]);

        $response->assertStatus(200);
    }

    public function test_applicant_can_apply_on_job_have_question(){
        Passport::actingAs(factory(Applicant::class)->create(), [], 'applicant');
        $url = route('applicantarea.jobs.apply', ["job" => $this->job->getRouteKey()]);

        $response = $this->json('POST', $url);

        $response->assertStatus(201);
    }

    public function test_applicant_cant_apply_on_jobs_dont_have_questions()
    {
        Passport::actingAs($this->recruiter, [], 'recruiter');
        $job = factory(Job::class)->create();
        $url = route('applicantarea.jobs.apply', ["job" => $job->getRouteKey()]);

        $response = $this->json('POST', $url);

        $response->assertStatus(401);
    }

    public function test_applicant_cant_apply_on_job_interview_more_than_once()
    {
        $applicant = factory(Applicant::class)->create();
        Passport::actingAs($applicant, [], 'applicant');
        $url = route('applicantarea.jobs.apply', ["job" => $this->job->getRouteKey()]);
        $this->json('POST', $url);
        $response = $this->json('POST', $url);

        $response->assertStatus(403);
    }

    public function test_recruiter_can_add_new_job()
    {
        Passport::actingAs($this->recruiter, [], 'recruiter');
        $url = route('recruiterarea.jobs.store');
        $data = factory('App\Job')->raw();
        $skill = factory(Skill::class)->create();
        $data["skills"] = [$skill->id];
        $question = $skill->questions()->create(['body' => "question #1"]);
        $data["questions"] = [$question->id];
        $response = $this->post($url, $data);
        $response->assertStatus(201);
    }

    public function test_recruiter_can_delete_existing_job_created_by_him()
    {
        Passport::actingAs($this->recruiter, [], 'recruiter');

        $job_arr = factory(Job::class)->raw();
        $job = $this->recruiter->jobs()->create($job_arr);
        $url = route('recruiterarea.jobs.destroy', $job["id"]);

        $response = $this->call('DELETE', $url);
        $response->assertStatus(204);
    }

    public function test_recruiter_can_update_existing_job()
    {
        Passport::actingAs($this->recruiter, [], 'recruiter');

        $job = factory(Job::class)->create();
        $url = route('recruiterarea.jobs.update', [$job["id"]]);
        $new_job = array(
            "title" => "NEW TITLE",
            "description" => "NEW DESCRIPTION",
            "accept_interviews_from" => "2020-08-09 21:54:15",
            "accept_interviews_until" => "2048-07-21 23:24:55",
            "interview_duration" => 3111,
            "recruiter_id" => 949,
            "updated_at" => "2020-08-09 21:54:15",
            "created_at" => "2020-08-09 21:54:15",
            "id" => 618
        );

        $skill = factory(Skill::class)->create();
        $new_job["skills"] = [$skill->id];
        $question = $skill->questions()->create(['body' => "question #1"]);
        $new_job["questions"] = [$question->id];

        $response = $this->call('PUT', $url, $new_job);
        
        $job = $job->fresh();
        $this->assertEquals($job->title, "NEW TITLE");
        $response->assertStatus(200);
    }

    public function test_recruiter_can_get_all_job_interviews_for_exact_job()
    {
        Passport::actingAs($this->recruiter, [], 'recruiter');
        $job_arr = factory(Job::class)->raw();
        $applicant = factory(Applicant::class)->create();
        $job = $this->recruiter->jobs()->create($job_arr);
        $job->interviews()->create(['applicant_id' => $applicant->getKey() ]);
        $url = route('recruiterarea.jobs.interviews.index', [$job["id"]]);
        $response = $this->get($url);
        $structure = [
            'data' => [
                '*' => [
                "id", 
                "submitted_at", 
                "created_at", 
                "updated_at",
                "applicant" => [
                    "id",
                    "name",
                    "email"
                ]
            ]
            ]
        ];
        $response->assertJsonStructure($structure);
        $response->assertStatus(200);
    }

    public function test_recruiter_may_not_have_jobs(){
        Passport::actingAs($this->recruiter, [], 'recruiter');
        $job_arr = factory(Job::class)->raw();
        $job = $this->recruiter->jobs()->create($job_arr);
        $url = route('recruiterarea.jobs.interviews.index', [$job["id"]]);
        $response = $this->get($url);

        $structure = [
            'data' => []
        ];
        $response->assertJsonStructure($structure);
        $response->assertStatus(200);
    }
}
