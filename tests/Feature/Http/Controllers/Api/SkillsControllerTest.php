<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Admin;
use App\Skill;
use Laravel\Passport\Passport;

class SkillsControllerTest extends TestCase
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
    public function test_admin_can_get_skills()
    {
        Passport::actingAs($this->admin, [], 'admin');
        
        $url = route('adminarea.skills.index');

        $response = $this->get($url);

        $structure = [
            'data' => [
                '*' => [
                  'id',
                  'name',
                  'created_at',
                  'updated_at'
                ]
            ]
        ];
        $response->assertJsonStructure($structure)->assertStatus(200);
    }

    public function test_admin_can_get_single_skill_by_id()
    {
        Passport::actingAs($this->admin, [], 'admin');
        $url = route('adminarea.skills.show', [$this->skill->getRouteKey()]);
        $response = $this->get($url);

        $response->assertJson(['data' => ['id' => $this->skill->getRouteKey()]])->assertStatus(200);
    }
}
