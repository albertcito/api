<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class LangType extends GraphQLType
{
    protected $attributes = [
        'name' => 'LangType',
        'description' => 'A Lang type'
    ];

    public function fields()
    {
        return [
            'idLang' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The lang ID'
            ],
            'code' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['min:3'],
                'description' => 'The lang ISO code'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['min:3'],
                'description' => 'The lang name (english, spanish...)'
            ],
        ];
    }
}
