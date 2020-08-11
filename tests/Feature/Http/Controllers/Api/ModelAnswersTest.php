<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Admin;
use App\Skill;
use App\Question;
use App\Answer;
use Laravel\Passport\Passport;

class ModelAnswersTest extends TestCase
{
    private $admin = null;
    private $skill = null;
    private $answer = null;
    private $question = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = factory(Admin::class)->create();
        $this->skill = factory(Skill::class)->create();
        $this->question = factory(Question::class)->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_can_get_model_answers_for_question()
    {
        Passport::actingAs($this->admin, [], 'admin');
        $question = factory(Question::class)->create();
        $question->modelAnswers()->create(['body' => "Answer # 1"]);
        
        $url = route('adminarea.questions.model_answers.index', ['question' => $question->getRouteKey()]);
        $response = $this->get($url);

        $structure = [
            'data' => [
                '*' => [
                  'id',
                  "body",
                  "question_id"
                ]
            ]
        ];
        $response->assertJsonStructure($structure)->assertStatus(200);
    }
}
