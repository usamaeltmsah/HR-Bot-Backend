<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionsControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_cant_get_job_questions()
    {
        $response = $this->json('GET', '/api/applicant/jobs/2/questions', [
            
        ]);

        /**
         * Status is 500: if the guest not registered
         * Status is 401: if the guest has no authentcation
         */

        if($response->getStatusCode() == 401) {
            $response->assertStatus(401);
        }
        else {
            $response->assertStatus(500);
        }
    }
}
