<?php

namespace App\GraphQL\Publics\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Logic\Session\LoginLogic as Login;

class UserLoginQuery extends Query
{
    protected $attributes = [
        'name' => 'UserLoginQuery',
        'description' => 'A query to return a user'
    ];

    public function type()
    {
        return GraphQL::type('UserType');
    }

    public function args()
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'rules' => ['required', 'email']
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => ['required', 'string']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $login = new Login();
        return $login->api(
            $args['email'],
            $args['password']
        );
    }
}
