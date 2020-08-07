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
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_cant_get_job_questions()
    {
        $user = factory(Applicant::class)->create();
        $job = factory(Job::class)->create();
        $interview = $job->interviews()->create(['applicant_id' => $user->getKey() ]);
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $interview->getRouteKey()]));


        $response->assertStatus(401);

    }
    
    public function test_applicant_can_get_job_questions()
    {
        $user = factory(Applicant::class)->create();
        $job = factory(Job::class)->create();
        $question = factory(Question::class)->create();
        $job->questions()->attach($question);
        $interview = $job->interviews()->create(['applicant_id' => $user->getKey()]);
        $response = Passport::actingAs($user, [], 'applicant');
        
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $interview->getRouteKey()]));
        $data = [
            "data" => [["id"=>$question->getRouteKey(), "body"=>$question->body]]
        ];
        $response->assertJson($data);

        $response->assertStatus(200);
    }

    public function test_applicant_cant_access_interview_questions_when_timeout(){
        $user = factory(Applicant::class)->create();
        $job = factory(Job::class)->create();
        $job->interview_duration = 0;
        $job->save();

        $interview = $job->interviews()->create(['applicant_id' => $user->getKey()]);
        Passport::actingAs($user, [], 'applicant');
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $interview->getRouteKey()]));
        $response->assertStatus(403);
    } 

    public function test_applicant_cant_access_any_interview_not_for_him(){
        $user = factory(Applicant::class)->create();
        $job = factory(Job::class)->create();

        $interview = $job->interviews()->create(['applicant_id' => $user->getKey()]);
        Passport::actingAs(factory(Applicant::class)->create(), [], 'applicant');
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $interview->getRouteKey()]));
        $response->assertStatus(403);
    }

    public function test_applicant_cant_access_interview_questions_when_he_make_submit(){
        $user = factory(Applicant::class)->create();
        $job = factory(Job::class)->create();

        $interview = $job->interviews()->create(['applicant_id' => $user->getKey()]);
        $interview->submitted_at = date("Y-m-d H:i:s");
        $interview->save();

        Passport::actingAs($user, [], 'applicant');
        $response = $this->json('GET', route('applicantarea.interviews.questions.index', ['interview' => $interview->getRouteKey()]));
        $response->assertStatus(403);
    }
}
