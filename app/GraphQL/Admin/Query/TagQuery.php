<?php

namespace App\GraphQL\Admin\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Model\Tag;

class TagQuery extends Query
{
    protected $attributes = [
        'name' => 'TagQuery',
        'description' => 'Query to return a tag'
    ];

    public function type()
    {
        return GraphQL::type('TagType');
    }

    public function args()
    {
        return [
            'idTag' => [
                'name' => 'idTag',
                'type' => Type::int(),
                'rules' => ['required','integer','min:1'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Tag::find($args['idTag']);
    }
}
