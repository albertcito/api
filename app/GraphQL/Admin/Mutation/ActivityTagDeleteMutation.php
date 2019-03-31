<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Model\ActivityTag;
use App\Exceptions\MessageError;

class ActivityTagDeleteMutation extends Mutation
{
    protected $attributes = [
        'name' => 'ActivityTagDeleteMutation',
        'description' => 'ActivityTag Delete Mutation'
    ];

    public function type()
    {
        return GraphQL::type('ActivityTagType');
    }

    public function args()
    {
        return [
            'idActivityTag' => [
                'type' => Type::int(),
                'rules' => ['required','numeric','min:1'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $activityTag = ActivityTag::find($args['idActivityTag']);
        $activityTag->delete();
        return $activityTag;
    }
}
