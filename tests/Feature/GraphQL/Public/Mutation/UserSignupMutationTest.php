<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserSignupMutationTest extends TestCase
{
    use WithoutMiddleware;

    public function testSingUp()
    {
        $faker = \Faker\Factory::create();
        $email = uniqid() . '@miaum.cl';
        $query = 'mutation {
                      signUpBasic(
                        name:"'. $faker->name .'"
                        email:"'.$email.'"
                        password:"123456"
                        passwordVerify:"123456"
                      ) {
                        idUser
                        name
                        email
                      }
                }';

        $expected = [
            'data' => [
                'signUpBasic' => [
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
