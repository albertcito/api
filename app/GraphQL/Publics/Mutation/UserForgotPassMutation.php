<?php

namespace App\GraphQL\Publics\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Logic\Session\PasswordLogic as Password;

class UserForgotPassMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UserForgotPassMutation',
        'description' => 'A query to return a user'
    ];

    public function type()
    {
        return GraphQL::type('SimpleMessageType');
    }

    public function args()
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'rules' => ['required', 'email']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Password::emailToken($args['email']);
    }
}
