<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\User;

class LangCreateMutationtionTest extends TestCase
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
            where('User.validEmail', true)
            ->inRandomOrder()
            ->first();

        $faker = \Faker\Factory::create();
        $query = 'mutation {
        	langCreate(
            code: "' .uniqid(). '",
            name: "' .$faker->word. '"
          )
          {
            idLang
            code
            name
          }
        }';

        $expected = [
            'data' => [
                'langCreate' => [
                    'idLang',
                    'code',
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
