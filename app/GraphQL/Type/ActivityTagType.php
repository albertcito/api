<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class ActivityTagType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ActivityTagType',
        'description' => 'ActivityTag type'
    ];

    public function fields()
    {
        return [
            'idActivityTag' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ActivityTag ID'
            ],
            'idActivity' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Activity ID'
            ],
            'idTag' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Tag ID'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Tag name'
            ],
        ];
    }

    protected function resolveNameField($root, $args)
    {
        $name = \App\Model\Tag::find($root->idTag);
        return $name->name;
    }
}
