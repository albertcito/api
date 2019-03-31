<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\{
    Activity,
    ActivityTag,
    Tag,
    User
};

class ActivityTagCreateMutationtionTest extends TestCase
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
        $tag = Tag::create([
            'name' => 'test ' . uniqid()
        ])->fresh();

        $queryTxt = 'mutation {
                    activityTagCreate(
                    idActivity: %u,
                    idTag: %u,
            ){
                idActivityTag
                idActivity
                idTag
                name
              }
          }';

        $query = sprintf(
            $queryTxt,
            $activity->idActivity,
            $tag->idTag
        );

        $expected = [
            'data' => [
                'activityTagCreate' => [
                    'idActivityTag',
                    'idActivity',
                    'idTag',
                    'name'
                ],
             ],
        ];

            $this->actingAs($user)
                ->json('post', '/graphql/admin', ['query' => $query])
                ->assertStatus(200)
                ->assertJsonStructure($expected);
    }
}
