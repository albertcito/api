<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class ImageFileSlotType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ImageFileSlotType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'idImage' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Primary key of the table'
            ],
            'idFile' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Primary key of the table'
            ],
            'idSlot' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Primary key of the table'
            ],
            'idDevice' => [
                'type' => Type::int(),
                'description' => 'Primary key of the table'
            ],
        ];
    }
}
