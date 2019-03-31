<?php

namespace App\GraphQL\Admin\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use Illuminate\Support\Facades\Hash;
use App\Model\User;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'UserQuery',
        'description' => 'A query to return a user'
    ];

    public function type()
    {
        return GraphQL::type('UserType');
    }

    public function args()
    {
        return [
            'idUser' => [
                'name' => 'idUser',
                'type' => Type::int(),
                'rules' => ['required','integer','min:1','exists:User,idUser'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return User::find($args['idUser']);
    }
}
