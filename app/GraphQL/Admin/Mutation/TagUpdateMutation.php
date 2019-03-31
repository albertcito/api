<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Model\Tag;

class TagUpdateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'TagUpdateMutation',
        'description' => 'Tag Update Mutation'
    ];

    public function type()
    {
        return GraphQL::type('TagType');
    }

    public function args()
    {
        return [
            'idTag' => [
                'type' => Type::nonNull(Type::int()),
                'rules' => ['required','integer','min:1'],
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required','min:3', new NoHTMLTags]
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $tag = Tag::find($args['idTag']);
        $tag->update($args);
        return $tag;
    }
}
