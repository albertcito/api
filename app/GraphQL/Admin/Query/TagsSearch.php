<?php

namespace App\GraphQL\Admin\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

use App\Model\ActivityTag;
use App\Exceptions\MessageError;

class TagsSearch extends Query
{
    protected $attributes = [
        'name' => 'TagsSearch',
        'description' => 'Search the Tags in Activities'
    ];

    public function type()
    {
        return GraphQL::paginate('TagType');
    }

    public function args()
    {
            $pageMin = 'min:' . \Config::get('constants.paginate.pageMin');
            $limitMin = 'min:' . \Config::get('constants.paginate.limitMin');
            $max = 'max:' . \Config::get('constants.paginate.max');
            $page = \Config::get('constants.paginate.page');
            $limit = \Config::get('constants.paginate.limit');
            return [
                'search' => [
                    'name' => 'search',
                    'type' => Type::string(),
                    'description' => 'String to search by Tag name',
                ],
                'idActivity' => [
                    'name' => 'idActivity',
                    'type' => Type::int(),
                    'description' => 'Activity ID to search from without the Tag name',
                    'rules' => ['required','integer','min:1'],
                ],
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
        return ActivityTag::
            searchTags($args['search'], $args['idActivity'])
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }
}
