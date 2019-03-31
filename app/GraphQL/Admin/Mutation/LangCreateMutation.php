<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Model\Lang;

class LangCreateMutation extends Mutation
{
    protected $attributes = [
        'name' => 'LangCreateMutation',
        'description' => 'A mutation to create lang'
    ];

    public function type()
    {
        return GraphQL::type('LangType');
    }

    public function args()
    {
        return [
            'code' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', new NoHTMLTags]
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required', new NoHTMLTags]
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Lang::create($args)->fresh();
    }
}
