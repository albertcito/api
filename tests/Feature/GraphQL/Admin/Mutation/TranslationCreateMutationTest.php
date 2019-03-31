<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\{
    User,
    Lang
};

class TranslationCreateMutationTest extends TestCase
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
        //company with Lang actives and users actives
        $langs = Lang::all();
        $faker = \Faker\Factory::create();
        $words = [];
        foreach ($langs as $lang) {
            $text[] = '{
                text: "'. $faker->word .'",
                idLang: '. $lang->idLang .'
            }';
        }
        $transalations = implode(',', $text);
        $query = 'mutation {
                  translationCreate(
                      code: "'. $faker->word. '('. uniqid() .')"
                      transalations: ['. $transalations .']
                  ) {
                    idTranslation
                    texts {
                        idLangText
                        text
                    }
                  }
                }';

        $expected = [
            'data' => [
                'translationCreate' => [
                    'idTranslation',
                    'texts' => [
                        '*' => [
                            'idLangText',
                            'text',
                        ]
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
