<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\{
    User,
    Tag
};

class TagsSearchQueryTest extends TestCase
{
    use WithoutMiddleware;

    public function test()
    {
        $user = User::where([
                'User.status' => 'active',
                'User.validEmail' => true
            ])
            ->inRandomOrder()
            ->select('User.idUser')->first();

        $faker = \Faker\Factory::create();
        $tag = Tag::create([
            'name' => $faker->word . '-' .uniqid(),
        ])->fresh();

        $query = '{
              tagsSearch(
                  search: "'.substr($tag->name, 0, 3).'",
                  idActivity: 13
              ) {
                data {
                  idTag
                  name
                }
              }
            }';

        $expected = [
            'data' => [
                'tagsSearch' => [
                    'data' => [
                        '*' => ['idTag', 'name']
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
