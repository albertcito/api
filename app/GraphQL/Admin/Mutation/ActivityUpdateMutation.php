<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Model\Activity;

class ActivityUpdateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'ActivityUpdateMutation',
        'description' => 'Activity Update Mutation'
    ];

    public function type()
    {
        return GraphQL::type('ActivityType');
    }

    public function args()
    {
        return [
            'idActivity' => [
                'type' =>Type::int(),
                'rules' => ['required','integer','min:1','exists:Activity,idActivity']
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
                'rules' => ['required', new NoHTMLTags]
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $activity = Activity::find($args['idActivity']);
        $activity->update($args);
        return $activity;
    }
}
