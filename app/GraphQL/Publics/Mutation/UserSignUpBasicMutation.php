<?php

namespace App\GraphQL\Publics\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\{
    NoHTMLTags,
    PassSpecialCharacter
};

use App\Logic\Session\SignUpBasicLogic as SignUp;

class UserSignUpBasicMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UserSignUpBasicMutation',
        'description' => 'A mutation to create a Basic User and send email token'
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
                'rules' => ['required', 'min:6']
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
        return SignUp::newUser(
            $args['name'],
            $args['email'],
            $args['password']
        );
    }
}
