<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Logic\Enum\ActivityType;
use App\Model\{
    Activity,
    ActivityClass,
    Company,
    LangTranslation,
    User
};

class ActivityCreateMutationtionTest extends TestCase
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
            inRandomOrder()
            ->select('User.idUser')
            ->first();

        $faker = \Faker\Factory::create();
        $nbWords = 3;
        $variableNbWords = true;
        $title = LangTranslation::inRandomOrder()->first();
        $description = LangTranslation::inRandomOrder()
            ->where('idTranslation', '<>', $title->idTranslation)
            ->first();

        $queryTxt = 'mutation {
                    activityCreate(
                    type: "%s",
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
            ActivityType::_DEFAULT,
            $title->idTranslation,
            $description->idTranslation,
            $faker->sentence($nbWords, $variableNbWords)
        );

        $expected = [
            'data' => [
                'activityCreate' => [
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
