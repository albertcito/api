<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Model\Tag;

class TagCreateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'TagCreateMutation',
        'description' => 'Tag creation Mutation'
    ];

    public function type()
    {
        return GraphQL::type('TagType');
    }

    public function args()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', new NoHTMLTags]
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $tag = Tag::create($args)->fresh();
        return $tag;
    }
}
