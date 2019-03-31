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

class ActivityDeleteMutationTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test()
    {
        $user = User::where('idUser', '<>', 1)
            ->inRandomOrder()
            ->first();
        $activity = Activity::inRandomOrder()->first();
        $faker = \Faker\Factory::create();

        $queryTxt = 'mutation {
        	   activityDelete(
                   idActivity:  %u,
            ){
                idActivity
                type
                idTitle
                idDescription
                json
              }
          }';

          $query = sprintf(
              $queryTxt,
              $activity->idActivity
          );

        $expected = [
            'data' => [
                'activityDelete' => [
                    'idActivity',
                    'type',
                    'idTitle',
                    'idDescription',
                    'json',
                ],
             ],
        ];

        $this->actingAs($user)
            ->json('post', '/graphql/admin', ['query' => $query])
            ->assertStatus(200)
            ->assertJsonStructure($expected);
    }
}
