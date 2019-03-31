<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\User;

class ActivitiesQueryTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test()
    {
        $user = User::where([
                'User.status' => 'active',
                'User.validEmail' => true
            ])
            ->select('User.idUser')
            ->first();
        $query = '{
              activities {
                data {
                    idActivity
                    type
                    idTitle
                    idDescription
                    json
                }
              }
            }';

        $expected = [
            'data' => [
                'activities' => [
                    'data' => [
                        '*' => [
                            'idActivity',
                            'type',
                            'idTitle',
                            'idDescription',
                            'json',
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
