<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\{
    Activity,
    LangTranslation,
    User
};

class ActivityUpdateMutationTest extends TestCase
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

        $faker = \Faker\Factory::create();
        $nbWords = 3;
        $variableNbWords = true;
        $title = LangTranslation::inRandomOrder()->first();
        $description = LangTranslation::inRandomOrder()
            ->where('idTranslation', '<>', $title->idTranslation)
            ->first();

            $queryTxt = 'mutation {
                        activityUpdate(
                        idActivity: %u
                        idTitle: %u,
                        idDescription: %u,
                        json: "%s"
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
            $activity->idActivity,
            $title->idTranslation,
            $description->idTranslation,
            $faker->sentence($nbWords, $variableNbWords)
        );
        $expected = [
            'data' => [
                'activityUpdate' => [
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
