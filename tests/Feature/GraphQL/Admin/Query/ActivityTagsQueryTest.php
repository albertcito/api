<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\{
    User,
    Activity
};

class ActivityTagsQueryTest extends TestCase
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
            ->inRandomOrder()
            ->select('User.idUser')
            ->first();
        $activity = Activity::inRandomOrder()->first();
        $query = '{
              activityTags(idActivity: '. $activity->idActivity .') {
                  idActivityTag
                  idActivity
                  idTag
                  }
            }';

        $expected =  [
            'data' => [
                'activityTags' => [
                    '*' => ['idActivityTag', 'idActivity', 'idTag']
                ],
             ],
        ];

        $this->actingAs($user)
            ->json('post', '/graphql/admin', ['query' => $query])
            ->assertStatus(200)
            ->assertJsonStructure($expected);
    }
}
