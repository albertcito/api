<?php

namespace App\GraphQL\Publics\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Logic\Session\SignUpLogic as SignUp;

class UserSignupMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UserSignupMutation',
        'description' => 'A mutation to create a User and send email token'
    ];

    public function type()
    {
        return GraphQL::type('UserType');
    }

    public function args()
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
                'rules' => ['required', new NoHTMLTags]
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'rules' => ['required','email','unique:User,email']
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
        return SignUp::signUp(
            $args['name'],
            $args['email'],
            $args['password']
        );
    }
}
