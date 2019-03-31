<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\User;

class UsersQueryTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test()
    {
        $user = User::
            where([
                'User.status' => 'Active',
                'User.validEmail' => true
            ])
            ->inRandomOrder()
            ->first();
        $query = '{
              users {
                data {
                  idUser
                  name
                  email
                  status
                  validEmail
                }
              }
            }';
        $expected = [
            'data' => [
                'users' => [
                    'data' => [
                        '*' => [
                            'idUser',
                            'name',
                            'status',
                            'validEmail',
                        ]
                    ]
                ],
             ],
        ];

        $this->actingAs($user)
            ->json('post', '/graphql/admin', ['query' => $query])
            ->assertStatus(200)
            ->assertJsonStructure($expected);
    }
}
