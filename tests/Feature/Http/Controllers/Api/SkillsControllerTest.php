<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Admin;
use App\Skill;
use DB;
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

    /**
     * TODO: Check that the skill added to database
     */
    public function test_admin_can_add_new_skill()
    {
        Passport::actingAs($this->admin, [], 'admin');
        
        $url = route('adminarea.skills.store');
        $skill = factory('App\Skill')->raw();
        $response = $this->post($url, $skill);
        // Check that it added successfully in database 
        $added_skill = DB::table('skills')->where('id', $response["data"]["id"])->get();
        $this->assertEquals($added_skill[0]->name, $skill["name"]);

        $response->assertStatus(201);

    }

    public function test_admin_can_update_existing_skill()
    {
        Passport::actingAs($this->admin, [], 'admin');
        
        $url = route('adminarea.skills.update', [$this->skill->getRouteKey()]);
        
        $new_data = array(
            'name' => "NEW NAME",
            'created_at',
            'updated_at'
        );

        $response = $this->call('PUT', $url, $new_data);
        $updated_skill = $this->skill->fresh();
        $this->assertEquals($updated_skill->name, "NEW NAME");
        $response->assertStatus(200);

    }

    public function test_admin_can_delete_skill_by_id()
    {
        Passport::actingAs($this->admin, [], 'admin');
        $skill = factory(Skill::class)->create();
        $url = route('adminarea.skills.destroy', [$skill->getRouteKey()]);
        
        $response = $this->call('DELETE', $url);
        $response->assertStatus(204);    
    }
}
