<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use App\Rules\NoHTMLTags;

use App\Model\User;

class UserUpdateProfile extends Mutation
{
    protected $attributes = [
        'name' => 'UserUpdateProfile',
        'description' => 'A query update Name and Company name'
    ];

    public function type()
    {
        return GraphQL::type('SimpleMessageType');
    }

    public function authorize(array $args)
    {
        $user = new \App\Logic\User\User();
        return $user->authorize($args['idUser']);
    }

    public function args()
    {
        return [
            'idUser' => [
                'name' => 'idUser',
                'type' => Type::int(),
                'rules' => ['required', 'integer', 'min:1', 'exists:User,idUser'],
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
                'rules' => ['required', new NoHTMLTags]
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::find($args['idUser']);
        $user->name = $args['name'];
        $user->save();

        $success = \App\Logic\Enum\SimpleMessage::SUCCESS;
        return [
            'message' => __('generic.updated_success'),
            'type' => $success
        ];
    }
}
