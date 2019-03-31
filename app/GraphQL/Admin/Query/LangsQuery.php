<?php

namespace App\GraphQL\Admin\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Model\Lang;

class LangsQuery extends Query
{
    protected $attributes = [
        'name' => 'LangsQuery',
        'description' => 'A query to get the Langs'
    ];

    public function type()
    {
        return GraphQL::paginate('LangType');
    }

    public function args()
    {
        $pageMin = 'min:' . \Config::get('constants.paginate.pageMin');
        $limitMin = 'min:' . \Config::get('constants.paginate.limitMin');
        $max = 'max:' . \Config::get('constants.paginate.max');
        $page = \Config::get('constants.paginate.page');
        $limit = \Config::get('constants.paginate.limit');
        return [
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
    }

    public function resolve($root, $args)
    {
        return Lang::paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
