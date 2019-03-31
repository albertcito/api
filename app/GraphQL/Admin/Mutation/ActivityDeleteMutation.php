<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Model\Activity;

class ActivityDeleteMutation extends Mutation
{
    protected $attributes = [
        'name' => 'ActivityDeleteMutation',
        'description' => 'Activity Delete Mutation'
    ];

    public function type()
    {
        return GraphQL::type('ActivityType');
    }

    public function args()
    {
        return [
            'idActivity' => [
                'type' => Type::int(),
                'rules' => ['required','integer','min:1','exists:Activity,idActivity'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $activity = Activity::find($args['idActivity']);
        $activity->delete();
        return $activity;
    }
}
