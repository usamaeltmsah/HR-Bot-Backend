<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Admin;
use App\Skill;
use Laravel\Passport\Passport;

class SkillQuestionsTest extends TestCase
{
    private $admin = null;
    private $skill = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = factory(Admin::class)->create();
        $this->skill = factory(Skill::class)->create();
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
}
