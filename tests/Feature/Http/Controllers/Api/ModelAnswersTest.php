<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Admin;
use App\Skill;
use App\Question;
use Laravel\Passport\Passport;

class ModelAnswersTest extends TestCase
{
    private $admin = null;
    private $question = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = factory(Admin::class)->create();
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

    public function test_admin_can_add_modelAnswer_for_existing_question()
    {
        Passport::actingAs($this->admin, [], 'admin');
        
        $question = factory(Question::class)->create();
        $question->modelAnswers()->create(['body' => "Answer # 1"]);

        $url = route('adminarea.questions.model_answers.store', ['question' => $question->getRouteKey()]);
        
        $response = $this->post($url, ['body' => "NEW ANSWER", "question_id" => $question->getRouteKey()]);

        // Count the number of model answers of this question
        $n_modelAnswers = count($question->modelAnswers);

        // The added model answer will be always the last model answer so need to check that it added successfully
        $added_modelAnswers = [$question->modelAnswers[$n_modelAnswers-1]['id'], $question->modelAnswers[$n_modelAnswers-1]['body']];
        $added_modelAnswers_from_response = [$response["data"]["id"], $response["data"]["body"]];

        // Test that the 2 arrays are equals 
        $this->assertEquals($added_modelAnswers, $added_modelAnswers_from_response);
        $response->assertStatus(201);
    }

    public function test_admin_can_get_modelAnswer_by_id()
    {
        Passport::actingAs($this->admin, [], 'admin');
        
        $model_answer = $this->question->modelAnswers()->create(['body' => "Answer # 1"]);

        $url = route('adminarea.model_answers.show', ['model_answer' => $model_answer->getRouteKey()]);
        
        $response = $this->get($url);
        $structure = [
            'data' => [
                  'id',
                  "body",
                  "question_id"
            ]
        ];
        $response->assertJsonStructure($structure)->assertStatus(200);
    }
}
