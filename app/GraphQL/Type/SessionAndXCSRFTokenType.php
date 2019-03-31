<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class SessionAndXCSRFTokenType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SessionAndXCSRFTokenType',
        'description' => 'A type of Session and XCSRFToken',
    ];
    public function fields()
    {
        return [
            'XCSRF' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The XCSRF-TOKEN'
            ],
            'user' => [
                'type' => GraphQL::type('UserType'),
                'description' => 'Data User'
            ],
        ];
    }
}
