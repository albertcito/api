<?php

namespace App\GraphQL\Publics\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Logic\Session\PasswordLogic as Password;

class UserResetPassMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UserResetPassMutation',
        'description' => 'A query to return a user'
    ];

    public function type()
    {
        return GraphQL::type('UserType');
    }

    public function args()
    {
        return [
            'token' => [
                'name' => 'token',
                'type' => Type::string(),
                'rules' => ['required', new NoHTMLTags]
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => ['required']
            ],
            'passwordVerify' => [
                'name' => 'passwordVerify',
                'type' => Type::string(),
                'rules' => ['required', 'same:password']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Password::resetLost(
            $args['token'],
            $args['password']
        );
    }
}
