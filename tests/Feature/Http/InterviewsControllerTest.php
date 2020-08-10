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
    }
    
    public function test_recruiter_can_get_interview_report_for_an_applicant()
    {
        Passport::actingAs($this->recruiter, [], 'recruiter');
        $job_arr = factory(Job::class)->raw();
        $job = $this->recruiter->jobs()->create($job_arr);
        $interview = $job->interviews()->create(['applicant_id' => $this->applicant->getKey() ]);
        $url = route("recruiterarea.interviews.show", ['interview' => $interview->getRouteKey()]);
        
        $response = $this->get($url);

        $structure = [
            'data' => [
                    "id", 
                    "score", 
                    "status", 
                    "submitted_at",
                    "created_at",
                    "updated_at",
                    "job" => [
                        "id",
                        "recruiter_id",
                        "title",
                        "description",
                        "accept_interviews_from",
                        "accept_interviews_until",
                        "interview_duration",
                        "created_at",
                        "updated_at"
                    ],
                    "applicant" => [
                        "id",
                        "name",
                        "email"
                    ],
                    "report" => [
                        '*' => [
                            "question" =>[[
                                "id",
                                "body",
                                "created_at",
                                "updated_at"
                            ]],
                            "answer" => [[
                                "id",
                                "body",
                                "score",
                                "question_id",
                                "interview_id",
                                "created_at",
                                "updated_at"
                            ]]
                        ]
                    ]   
            ]
        ];
        $response->assertJsonStructure($structure);
        $response->assertStatus(200);
    }

    public function test_recruiter_can_update_interview_status()
    {
        Passport::actingAs($this->recruiter, [], 'recruiter');
        $job_arr = factory(Job::class)->raw();
        $job = $this->recruiter->jobs()->create($job_arr);
        $interview = $job->interviews()->create(['applicant_id' => $this->applicant->getKey() ]);
        $url = route("recruiterarea.interviews.status", ['interview' => $interview->getRouteKey()]);
        
        $new_data = array(
            "score" => 8.4,
            "status" => "not selected",
            "submitted_at" => "2020-08-09 21:54:15",
            "created_at" => "2048-07-21 23:24:55",
            "updated_at" => "2020-08-09 21:54:15",
            "job",
            "applicant"
        );

        $response = $this->call('PUT', $url, $new_data);

        $new_interview = $interview->fresh();
        $this->assertEquals($new_interview->status, "not selected");
        $response->assertStatus(200);
    }
}