<?php

namespace App\GraphQL\Admin\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Model\ActivityTag;
use App\Exceptions\MessageError;

class ActivityTagsQuery extends Query
{
    protected $attributes = [
        'name' => 'ActivityTagsQuery',
        'description' => 'Query to get the list of Tags for an Activity'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('ActivityTagType'));
    }

    public function args()
    {
        return [
            'idActivity' => [
                'name' => 'idActivity',
                'type' => Type::int(),
                'rules' => ['required','numeric','min:1'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return ActivityTag::where($args)->get();
    }
}
