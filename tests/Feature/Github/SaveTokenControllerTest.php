<?php

namespace Tests\Feature\Github;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SaveTokenControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanSaveGitHubToken()
    {
        $this->actingAsRandomUser()->post('/api/v1/Github/', [
            'github_token' => 'Example-github-token'
        ])->assertCreated()->assertJson([
            'message' => 'ok',
        ]);

        $this->user->refresh();

        $this->assertNotNull($this->user->github_token);

        
    }
}
