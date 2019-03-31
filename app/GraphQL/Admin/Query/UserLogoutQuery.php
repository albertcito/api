<?php

namespace App\GraphQL\Admin\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Illuminate\Support\Facades\Auth;

class UserLogoutQuery extends Query
{
    protected $attributes = [
        'name' => 'UserLogoutQuery',
        'description' => 'A query revoke token'
    ];

    public function type()
    {
        return GraphQL::type('SimpleMessageType');
    }

    public function args()
    {
        return [];
    }

    public function resolve($root, $args)
    {
        \Auth::User()->token()->revoke();
        return  ['message' => __('user.logout')];
    }
}
