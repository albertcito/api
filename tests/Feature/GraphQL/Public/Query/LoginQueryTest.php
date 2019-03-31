<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Model\User;

class LoginQueryTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test()
    {
        $password = "123456";
        $user = factory(User::class)->create([
            'password' => bcrypt($password),
            'validEmail' => true,
        ]);

        $query = '{
              login(
                  email:"' .$user->email. '",
                  password:"'. $password .'"
              ){
                idUser
                name
                email
              }
            }';

        $expected = [
            'data' => [
                'login' => [
                    'idUser',
                    'name',
                    'email'
                ],
             ],
        ];

        $this->post('/graphql', ['query' => $query])
            ->assertStatus(200)
            ->assertJsonStructure($expected);
    }
}
