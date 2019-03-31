<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Model\{
    ActivityTag,
    Tag
};
use App\Exceptions\MessageError;

class ActivityTagCreateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'ActivityTagCreateMutation',
        'description' => 'ActivityTag creation Mutation'
    ];

    public function type()
    {
        return GraphQL::type('ActivityTagType');
    }

    public function args()
    {
        return [
            'idActivity' => [
                'type' => Type::int(),
                'rules' => ['required','numeric','min:1']
            ],
            'idTag' => [
                'type' => Type::int(),
                'rules' => ['numeric','min:1','required_without:name']
            ],
            'name' => [
                'type' => Type::string(),
                'rules' => ['required_without:idTag']
            ],
        ];
    }

    public function getIdTag($args)
    {
        if (empty($args['idTag'])) {
            $tag = Tag::where([
                'name' => $args['name'],
                'idCompany' => $idCompany
            ])->first();
            if ($tag) {
                return $tag->idTag;
            }

            $tag = Tag::create([
                'name' => $args['name'],
                'idCompany' => $idCompany
            ])->fresh();
            return $tag->idTag;
        }

        return $args['idTag'];
    }

    public function resolve($root, $args)
    {
        $idTag = $this->getIdTag($args);
        $whereArray = [
            'idActivity' => $args['idActivity'],
            'idTag' => $idTag
        ];
        $activityTag = ActivityTag::where($whereArray)->count();
        if ($activityTag > 0) {
            throw with(new MessageError('Tag already exist in the Activity'));
        }

        return ActivityTag::create($whereArray)->fresh();
    }
}
