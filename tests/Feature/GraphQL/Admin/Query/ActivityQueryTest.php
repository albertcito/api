<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\{
    Activity,
    User
};

class ActivityQueryTest extends TestCase
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
                'User.status' => 'active',
                'User.validEmail' => true
            ])
            ->inRandomOrder()
            ->first();
        $activity = Activity::inRandomOrder()->first();
        $query = '{
              activity(idActivity: ' .$activity->idActivity. ') {
                  idActivity
                  type
                  idTitle
                  idDescription
                  json
              }
            }';
        $expected = [
            'data' => [
                'activity' => [
                    'idActivity',
                    'type',
                    'idTitle',
                    'idDescription',
                    'json',
                ]
            ]
        ];

        $this->actingAs($user)
            ->json('post', '/graphql/admin', ['query' => $query])
            ->assertStatus(200)
            ->assertJsonStructure($expected);
    }
}
