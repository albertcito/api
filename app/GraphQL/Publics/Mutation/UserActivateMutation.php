<?php

namespace App\GraphQL\Publics\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Logic\Session\ActiveEmail;

class UserActivateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UserActivateMutation',
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
        ];
    }

    public function resolve($root, $args)
    {
        return ActiveEmail::activate($args['token']);
    }
}
