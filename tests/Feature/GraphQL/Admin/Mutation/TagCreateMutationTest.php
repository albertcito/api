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

class TagCreateMutationtionTest extends TestCase
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
        $query = 'mutation {
        	tagCreate(
            name: "' .$faker->word. ' (' .uniqid(). ')"
          )
          {
            idTag
            name
          }
        }';

        $expected = [
            'data' => [
                'tagCreate' => [
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
