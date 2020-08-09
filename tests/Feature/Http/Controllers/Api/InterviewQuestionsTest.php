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

class InterviewQuestionsTest extends TestCase
{
    private $user = null;
    private $job = null;
    private $interview = null;
    private $question = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(Applicant::class)->create();
        $this->job = factory(Job::class)->create();
        $this->interview = $this->job->interviews()->create(['applicant_id' => $this->user->getKey() ]);
        $this->question = factory(Question::class)->create();
        $this->job->questions()->attach($this->question);
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
        Passport::actingAs($this->user, [], 'applicant');
        
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $this->interview->getRouteKey()]));
        $data = [
            "data" => [["id"=>$this->question->getRouteKey(), "body"=>$this->question->body]]
        ];
        $response->assertJson($data);

        $response->assertStatus(200);
    }

    public function test_applicant_cant_access_interview_questions_when_timeout(){
        $interview_duration = $this->job->interview_duration;
        $this->job->interview_duration = 0;
        $this->job->save();
        $this->interview = $this->job->interviews()->create(['applicant_id' => $this->user->getKey() ]);

        Passport::actingAs($this->user, [], 'applicant');
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $this->interview->getRouteKey()]));
        $response->assertStatus(403);
        $this->job->interview_duration = $interview_duration;
        $this->job->save();
    } 

    public function test_applicant_cant_access_any_interview_not_for_him(){
        Passport::actingAs(factory(Applicant::class)->create(), [], 'applicant');
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $this->interview->getRouteKey()]));
        $response->assertStatus(403);
    }

    public function test_applicant_cant_access_interview_questions_when_he_make_submit(){
        $submitted_at = $this->interview->submitted_at;
        $this->interview->submitted_at = date("Y-m-d H:i:s");
        $this->interview->save();

        Passport::actingAs($this->user, [], 'applicant');
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $this->interview->getRouteKey()]));
        $response->assertStatus(403);

        $this->interview->submitted_at = $submitted_at;
        $this->interview->save();
    }

    public function test_applicant_cant_save_an_empty_answer(){
        Passport::actingAs($this->user, [], 'applicant');
        $url = route('applicantarea.interviews.questions.answer', [
            'interview' => $this->interview->getRouteKey(), 
            'question' => $this->question->getRouteKey()
        ]);

        $response = $this->json('POST', $url);

        $response->assertStatus(422);
    }

    public function test_applicant_can_answer_question(){
        Passport::actingAs($this->user, [], 'applicant');
        $url = route('applicantarea.interviews.questions.answer', [
            'interview' => $this->interview->getRouteKey(), 
            'question' => $this->question->getRouteKey()
        ]);

        $response = $this->json('POST', $url, ["body" => "fdhj"]);

        $response->assertStatus(201);
    }

    public function test_applicant_can_apply_on_job(){
        Passport::actingAs(factory(Applicant::class)->create(), [], 'applicant');
        $url = route('applicantarea.jobs.apply', ["job" => $this->job->getRouteKey()]);

        $response = $this->json('POST', $url);

        $response->assertStatus(201);
    }

    public function test_applicant_can_end_interview(){
        Passport::actingAs($this->user, [], 'applicant');

        $url = route('applicantarea.interviews.submit', ["interview" => $this->interview->getRouteKey()]);
        
        $response = $this->json('POST', $url);

        $response->assertStatus(200);
    }
}
