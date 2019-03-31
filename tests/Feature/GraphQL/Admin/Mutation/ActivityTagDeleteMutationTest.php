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

class ActivityTagDeleteMutationTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test()
    {
        //Get a user with all the data
        $user = User::where([
                'User.status' => 'active',
                'User.validEmail' => true
            ])
            ->inRandomOrder()
            ->select('User.idUser')
            ->first();

        $tag = Tag::create([
            'name' => 'test ' . uniqid()
        ])->fresh();
        $activity = Activity::inRandomOrder()->first();
        $activityTag = ActivityTag::create([
            'idTag'=> $tag->idTag,
            'idActivity' => $activity->idActivity
        ])->fresh();

        $queryTxt = 'mutation {
        	   activityTagDelete(idActivityTag:%u){
                idActivityTag
                idActivity
                idTag
                name
              }
          }';
          $query = sprintf(
              $queryTxt,
              $activityTag->idActivityTag
          );

        $expected = [
            'data' => [
                'activityTagDelete' => [
                    'idActivityTag',
                    'idActivity',
                    'idTag',
                    'name',
                ],
             ],
        ];

        $this->actingAs($user)
            ->json('post', '/graphql/admin', ['query' => $query])
            ->assertStatus(200)
            ->assertJsonStructure($expected);
    }
}
