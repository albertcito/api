<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\User;

class TranslationsQueryTest extends TestCase
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
            where([
                'User.status' => 'active',
                'User.validEmail' => true
            ])
            ->inRandomOrder()
            ->first();
        $query = '{
              translations {
                data {
                  idTranslation
                  texts {
                    idLang
                    idTranslation
                    idLangText
                  }
                }
              }
            }';

        $expected = [
            'data' => [
                'translations' => [
                    'data' => [
                        '*' => [
                            'idTranslation',
                            'texts' => [
                                '*' => [
                                    'idLang',
                                    'idTranslation',
                                    'idLangText'
                                ]
                            ]
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
