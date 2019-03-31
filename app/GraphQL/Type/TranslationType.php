<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class TranslationType extends GraphQLType
{
    protected $attributes = [
        'name' => 'TranslationType',
        'description' => 'A Translation type'
    ];

    public function fields()
    {
        $limitMin = 'min:' . \Config::get('constants.paginate.limitMin');
        $pageMin = 'min:' . \Config::get('constants.paginate.pageMin');
        $max = 'max:' . \Config::get('constants.paginate.max');
        $page = \Config::get('constants.paginate.page');
        $limit = \Config::get('constants.paginate.limit');
        $pagination = [
            'page' => [
                'name' => 'page',
                'type' => Type::int(),
                'description' => 'Current page result.',
                'defaultValue' => $page,
                'rules' => ['integer', $pageMin]
            ],
            'limit' => [
                'name' => 'limit',
                'type' => Type::int(),
                'description' => 'Limit result.',
                'defaultValue' => $limit,
                'rules' => ['integer', $limitMin, $max]
            ],
        ];

        return [
            'idTranslation' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The Translation ID'
            ],
            'texts' => [
                'type' => Type::listOf(GraphQL::type('TextType')),
                'description' => 'Text group',
            ],
        ];
    }

    protected function resolveTextsField($root, $args)
    {
        return $root->texts()->get();
    }
}
