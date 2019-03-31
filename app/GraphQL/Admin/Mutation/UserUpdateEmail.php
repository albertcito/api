<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use Illuminate\Support\Facades\Hash;
use App\Exceptions\MessageError;
use App\Model\User;

class UserUpdateEmail extends Mutation
{
    protected $attributes = [
        'name' => 'UserUpdateEmail',
        'description' => 'A query update user email'
    ];

    public function type()
    {
        return GraphQL::type('SimpleMessageType');
    }

    public function args()
    {
        return [
            'idUser' => [
                'name' => 'idUser',
                'type' => Type::int(),
                'rules' => ['required', 'integer', 'min:1', 'exists:User,idUser'],
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'rules' => ['required','email','unique:User,email']
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => ['required']
            ],
        ];
    }

    public function authorize(array $args)
    {
        $user = new \App\Logic\User\User();
        return $user->authorize($args['idUser']);
    }

    public function resolve($root, $args)
    {
        $user = User::find($args['idUser']);
        if (!Hash::check($args['password'], $user->password)) {
            throw with(new MessageError(__('user.password_wrong')));
        }

        $user->email = $args['email'];
        $user->save();

        $success = \App\Logic\Enum\SimpleMessage::SUCCESS;
        return [
            'message' => __('generic.updated_success'),
            'type' => $success
        ];
    }
}
