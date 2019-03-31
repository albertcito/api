<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

use App\User;

class SimpleMessageType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SimpleMessageType',
        'description' => 'A type of a simple message'
    ];

    public function fields()
    {
        $status = \App\Logic\Enum\SimpleMessage::getList();
        $default = \App\Logic\Enum\SimpleMessage::_DEFAULT;
        return [
            'message' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Simple Message'
            ],
            'type' => [
                'type' => Type::string(),
                'description' => 'Values: '.$status,
                'defaultValue' => $default
            ]
        ];
    }
}
