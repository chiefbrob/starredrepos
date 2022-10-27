<?php

namespace Tests\Feature\Github;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Tests\Feature\MocksGithubAPI;
use Tests\TestCase;

class GetStarredRepositoriesControllerTest extends TestCase
{
    use RefreshDatabase;
    //use MocksGithubAPI;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetStarredRepos()
    {
        $this->markTestIncomplete('mocking failed');
        $this->addMockHttpResponse(json_encode([]));
        $this->actingAsRandomUser()
            ->create(['github_token' => 'some-token'])
            ->get(route('v1.repositories.starred'))
            ->assertOk();
    }
}
