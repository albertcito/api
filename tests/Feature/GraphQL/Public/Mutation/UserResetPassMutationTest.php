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

class UserResetPassMutationTest extends TestCase
{
    use WithoutMiddleware;

    public function testResetPass()
    {
        $user = factory(User::class)->create(['validEmail' => 1]);
        $token = UserToken::addResetPass($user->idUser);

        $query = 'mutation {
                	resetpass(
                        token:"'. $token .'",
                        password:"123456",
                        passwordVerify:"123456"
                    ) {
                        idUser
                        name
                        email
                      }
                }';

        $expected = [
            'data' => [
                'resetpass' => [
                    'idUser',
                    'name',
                    'email'
                ],
             ],
        ];

        $result = $this->post('/graphql', ['query' => $query])
            ->assertStatus(200)
            ->assertJsonStructure($expected);
    }
}
