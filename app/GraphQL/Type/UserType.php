<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

use App\Model\User;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'UserType',
        'description' => 'A type of User',
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
            'idUser' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'User identification, primary key'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['min:3'],
                'description' => 'User name'
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'rules' => ['min:3'],
                'description' => 'User email'
            ],
            'status' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'User Status, values: Active, Inactive, Blocked'
            ],
            'validEmail' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Email Validation flag, values: True, False'
            ],
            'accessToken' => [
                'type' => Type::string(),
                'description' => 'Session api token passport'
            ],
        ];
    }
}
