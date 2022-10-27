<?php

namespace Tests\Feature\Github;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTokenControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteToken()
    {
        $user = User::factory()->create([
            'github_token' => 'Example-github-token'
        ]);
        $response = $this->actingAs($user)->delete(route('v1.github_token.delete'));

        $response
            ->assertStatus(202)
            ->assertJson([
                'message' => 'ok',
            ]);
    }
}
