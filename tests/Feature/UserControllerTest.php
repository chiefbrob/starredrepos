<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoadUserProfile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('v1.user'))->assertOk()->assertJson([
            'name' => $user->name,
            'email' => $user->email
        ]);

    }
}
