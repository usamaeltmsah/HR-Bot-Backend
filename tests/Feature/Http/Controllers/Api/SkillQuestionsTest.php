<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Admin;
use App\Recruiter;
use App\Skill;
use App\Question;
use Laravel\Passport\Passport;

class SkillQuestionsTest extends TestCase
{
    private $admin = null;
    private $recruiter = null;
    private $skill = null;
    private $question = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = factory(Admin::class)->create();
        $this->recruiter = factory(Recruiter::class)->create();
        $this->skill = factory(Skill::class)->create();
        $this->question = factory(Question::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    

    public function test_admin_can_get_skill_questions()
    {
        Passport::actingAs($this->admin, [], 'admin');

        $this->skill->questions()->create(['body' => "question #1"]);
        $this->skill->questions()->create(['body' => "question #2"]);
        
        $url = route('adminarea.skills.questions.index', [$this->skill->getRouteKey()]);

        $response = $this->get($url);
        $structure = [
            'data' => [
                '*' => [
                  'id',
                  'skill_id',
                  'body',
                  'created_at',
                  'updated_at',
                ]
            ]
        ];
        $response->assertJsonStructure($structure)->assertStatus(200);
        $response->assertStatus(200);
        
    }

    public function test_admin_can_get_single_question_by_id()
    {
        Passport::actingAs($this->admin, [], 'admin');
        $url = route('adminarea.questions.show', ['question' => $this->question->id]);
        $response = $this->get($url);

        $response->assertJson(['data' => ['id' => $this->question->getRouteKey()]])->assertStatus(200);
    }

    public function test_admin_can_add_questions_for_existing_skill()
    {
        Passport::actingAs($this->admin, [], 'admin');
        $this->skill->questions()->create(['body' => "question #1"]);
        $this->skill->questions()->create(['body' => "question #2"]);
        $url = route('adminarea.skills.questions.store', [$this->skill->getRouteKey()]);
        
        $response = $this->post($url, ['body' => "NEW Question"]);

        // Count the number of question of this skill
        $n_questions = count($this->skill->questions);

        // The added skill will be always the last skill so need to check that it added successfully
        $added_skill_q = [$this->skill->questions[$n_questions-1]['id'], $this->skill->questions[$n_questions-1]['body']];
        $added_skill_q_from_response = [$response["data"]["id"], $response["data"]["body"]];

        // Test that the 2 arrays are equals 
        $this->assertEquals($added_skill_q, $added_skill_q_from_response);
        $response->assertStatus(201);
    }

    public function test_admin_can_update_existing_questions()
    {
        Passport::actingAs($this->admin, [], 'admin');
        $url = route('adminarea.questions.update', ['question' => $this->question->id]);

        $new_data = array(
            'body' => "NEW Question?",
        );

        $response = $this->call('PUT', $url, $new_data);
        $updated_question = $this->question->fresh();
        $this->assertEquals($updated_question->body, "NEW Question?");
        $response->assertStatus(200);
    }

    public function test_admin_can_delete_questions()
    {
        Passport::actingAs($this->admin, [], 'admin');
        $url = route('adminarea.questions.destroy', ['question' => $this->question->id]);

        $response = $this->call('DELETE', $url);
        $response->assertStatus(204);
    }

    public function test_recruiter_can_get_skill_questions()
    {
        Passport::actingAs($this->recruiter, [], 'recruiter');

        $this->skill->questions()->create(['body' => "question #1"]);
        $this->skill->questions()->create(['body' => "question #2"]);
        
        $url = route('recruiterarea.skills.questions.index', [$this->skill->getRouteKey()]);

        $response = $this->get($url);
        $structure = [
            'data' => [
                '*' => [
                  'id',
                  'skill_id',
                  'body',
                  'created_at',
                  'updated_at',
                ]
            ]
        ];
        $response->assertJsonStructure($structure)->assertStatus(200);
        $response->assertStatus(200);
        
    }
}
