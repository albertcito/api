<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\User;

class UserForgotPassMutationTest extends TestCase
{
    use WithoutMiddleware;

    public function testForgotPass()
    {
        $user = factory(User::class)->create([
            'validEmail' => 1,
        ]);
        $query = 'mutation {
                      forgotpass(email:"'.$user->email.'") {
                        message
                      }
                 }';

        $expected = [
            'data' => [
                'forgotpass' => [
                    'message'
                ],
             ],
        ];

        $result = $this->post('/graphql', ['query' => $query])
            ->assertStatus(200)
            ->assertJsonStructure($expected);
    }
}
