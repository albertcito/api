<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use App\Model\Tag;

class TagDeleteMutation extends Mutation
{
    protected $attributes = [
        'name' => 'TagDeleteMutation',
        'description' => 'Tag Delete Mutation'
    ];

    public function type()
    {
        return GraphQL::type('TagType');
    }

    public function args()
    {
        return [
            'idTag' => [
                'type' => Type::int(),
                'rules' => ['required','integer','min:1'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $tag = Tag::find($args['idTag']);
        $tag->delete();
        return $tag;
    }
}
