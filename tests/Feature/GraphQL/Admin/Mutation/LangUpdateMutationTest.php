<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\{
    Lang,
    User
};

class LangUpdateMutationTest extends TestCase
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
        $lang = Lang::create([
            'code' =>  uniqid(),
            'name' => 'example1'
        ])->fresh();
        $faker = \Faker\Factory::create();
        $query = 'mutation {
        	langUpdate(
                idLang: '. $lang->idLang .'
                code: "'. uniqid() .'",
                name: "'. $faker->sentence(2) .'"
            ) {
                idLang
                code
                name
           }
        }';

        $expected = [
            'data' => [
                'langUpdate' => [
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
