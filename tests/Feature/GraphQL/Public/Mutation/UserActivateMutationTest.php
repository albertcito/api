<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\{
    User,
    UserToken
};

class UserActivateMutationTest extends TestCase
{
    use WithoutMiddleware;

    public function testForgotPass()
    {
        $user = factory(User::class)->create(['validEmail' => 0]);
        $token = UserToken::addValidEmail($user->idUser);

        $query = 'mutation {
                  activate(token:"'. $token .'") {
                    idUser
                    name
                    email
                  }
                }';

        $expected = [
            'data' => [
                'activate' => [
                    'idUser',
                    'name',
                    'email',
                ],
             ],
        ];

        $result = $this->post('/graphql', ['query' => $query])
            ->assertStatus(200)
            ->assertJsonStructure($expected);
    }
}
