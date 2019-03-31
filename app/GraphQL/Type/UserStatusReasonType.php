<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class UserStatusReasonType extends GraphQLType
{
    protected $attributes = [
        'name' => 'UserStatusReasonType',
        'description' => 'A type for User Status Reason'
    ];
    public function fields()
    {
        return [
            'idUserStatusReason' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'User Status Reason primary key'
            ],
            'idUser' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'User primary key'
            ],
            'status' => [
                'type' =>  Type::string(),
                'description' => 'User status'
            ],
            'reason' => [
                'type' =>  Type::string(),
                'description' => 'Reason description'
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Date to request the file',
                'resolve' => function ($root) {
                    $dateFull = \Config::get('constants.dateFormat.full');
                    return (string) $root->created_at->format($dateFull);
                }
            ],
        ];
    }
}
