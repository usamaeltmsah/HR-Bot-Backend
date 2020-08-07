<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Applicant;
use App\Interview;
use App\Job;
use App\Question;
use Laravel\Passport\Passport;

class JobQuestionsControllerTest extends TestCase
{
    private $user = null;
    private $job = null;
    private $interview = null;
    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(Applicant::class)->create();
        $this->job = factory(Job::class)->create();
        $this->interview = $this->job->interviews()->create(['applicant_id' => $this->user->getKey() ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_cant_get_job_questions()
    {
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $this->interview->getRouteKey()]));

        $response->assertStatus(401);

    }
    
    public function test_applicant_can_get_job_questions()
    {
        $question = factory(Question::class)->create();
        $this->job->questions()->attach($question);
        Passport::actingAs($this->user, [], 'applicant');
        
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $this->interview->getRouteKey()]));
        $data = [
            "data" => [["id"=>$question->getRouteKey(), "body"=>$question->body]]
        ];
        $response->assertJson($data);

        $response->assertStatus(200);
    }

    public function test_applicant_cant_access_interview_questions_when_timeout(){
        $this->job->interview_duration = 0;
        $this->job->save();

        Passport::actingAs($this->user, [], 'applicant');
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $this->interview->getRouteKey()]));
        $response->assertStatus(403);
    } 

    public function test_applicant_cant_access_any_interview_not_for_him(){
        Passport::actingAs(factory(Applicant::class)->create(), [], 'applicant');
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $this->interview->getRouteKey()]));
        $response->assertStatus(403);
    }

    public function test_applicant_cant_access_interview_questions_when_he_make_submit(){
        $this->interview->submitted_at = date("Y-m-d H:i:s");
        $this->interview->save();

        Passport::actingAs($this->user, [], 'applicant');
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $this->interview->getRouteKey()]));
        $response->assertStatus(403);
    }
}
