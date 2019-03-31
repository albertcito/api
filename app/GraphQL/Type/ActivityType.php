<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class ActivityType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ActivityType',
        'description' => 'Activity type'
    ];

    public function fields()
    {
        return [
            'idActivity' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Activity ID'
            ],
            'type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'type'
            ],
            'idTitle' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Title Translation ID'
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Activity Title Translation'
            ],
            'idDescription' => [
                'type' => Type::int(),
                'description' => 'Description Translation ID'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Activity Description Translation'
            ],
            'json' => [
                'type' => Type::string(),
                'description' => 'Jason File Content'
            ],
        ];
    }

    protected function resolveTitleField($root, $args)
    {
        return $root->title(1);
    }

    protected function resolveDescriptionField($root, $args)
    {
        return $root->description(1);
    }
}
