<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Model\Activity;

class ActivityCreateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'ActivityCreateMutation',
        'description' => 'Activity creation Mutation'
    ];

    public function type()
    {
        return GraphQL::type('ActivityType');
    }

    public function args()
    {
        return [
            'type' => [
                'type' => Type::string(),
                'rules' => ['required']
            ],
            'idTitle' => [
                'type' => Type::int(),
                'rules' => ['required','integer','min:1','exists:LangTranslation,idTranslation']
            ],
            'idDescription' => [
                'type' => Type::int(),
                'rules' => ['integer','min:1','exists:LangTranslation,idTranslation']
            ],
            'json' => [
                'type' => Type::string(),
                'rules' => [new NoHTMLTags]
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Activity::create($args)->fresh();
    }
}
