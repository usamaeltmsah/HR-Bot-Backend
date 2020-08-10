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
}