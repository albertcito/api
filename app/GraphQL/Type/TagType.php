<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class TagType extends GraphQLType
{
    protected $attributes = [
        'name' => 'TagType',
        'description' => 'A Tag type'
    ];

    public function fields()
    {
        return [
            'idTag' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Tag ID'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['min:3'],
                'description' => 'Tag name'
            ],
        ];
    }
}
