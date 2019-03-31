<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\{
    Tag,
    User
};

class TagUpdateMutationTest extends TestCase
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
        $faker = \Faker\Factory::create();
        $tag = Tag::inRandomOrder()->first();
        $query = 'mutation {
        	tagUpdate(
                idTag: '. $tag->idTag .'
                name: "' .$faker->word. ' (' .uniqid(). ')"
            ) {
                idTag
                name
           }
        }';

        $expected = [
            'data' => [
                'tagUpdate' => [
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
