<?php

namespace App\GraphQL\Admin\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

use Illuminate\Support\Facades\Hash;
use App\Exceptions\MessageError;
use App\Model\User;

class UserUpdatePassword extends Mutation
{
    protected $attributes = [
        'name' => 'UserUpdatePassword',
        'description' => 'A query update user password'
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
            'currentPassword' => [
                'name' => 'currentPassword',
                'type' => Type::string(),
                'rules' => ['required','min:6']
            ],
            'newPassword' => [
                'name' => 'newPassword',
                'type' => Type::string(),
                'rules' => ['required','min:6']
            ],
            'confirmNewPassword' => [
                'name' => 'confirmNewPassword',
                'type' => Type::string(),
                'rules' => ['required', 'min:6', 'same:newPassword']
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
        if (!Hash::check($args['currentPassword'], $user->password)) {
            throw with(new MessageError(__('user.password_wrong')));
        }
        $user->password = bcrypt($args['newPassword']);
        $user->save();

        $success = \App\Logic\Enum\SimpleMessage::SUCCESS;
        return [
            'message' => __('generic.updated_success'),
            'type' => $success
        ];
    }
}
