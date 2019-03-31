<?php

namespace App\GraphQL\Admin\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Model\Activity;

class ActivityQuery extends Query
{
    protected $attributes = [
        'name' => 'ActivityQuery',
        'description' => 'Query to return an Activity'
    ];

    public function type()
    {
        return GraphQL::type('ActivityType');
    }

    public function args()
    {
        return [
            'idActivity' => [
                'name' => 'idActivity',
                'type' => Type::int(),
                'rules' => ['required','integer','min:1','exists:Activity,idActivity'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Activity::find($args['idActivity']);
    }
}
