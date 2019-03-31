<?php

namespace App\Logic\Session;

use Illuminate\Support\Facades\URL;
use App\Exceptions\MessageError;
use App\Logic\FrontendURL;
use App\Model\{
    User,
    UserToken
};


class SignUpBasicLogic
{
    /**
     * Create a new account
     * @param  string $name user name
     * @param  string $email  user email
     * @param  string $password user password
     * @param  string $company  user company name
     * @return User Eloquent class
     */
    public static function newUser($name, $email, $password)
    {

        $userExist = User::where('email', $email)->count();
        if ($userExist > 0) {
            throw with(new MessageError(__('user.email_in_use')));
        }

        $user = User::create([
            'email' => $email,
            'password' => bcrypt($password),
            'name' => $name,
        ])->fresh();

        $link = FrontendURL::validEmail($user->idUser);

        \Mail::send(
            'emails.activation',
            [
                'user' => $user,
                'link' => $link
            ],
            function ($message) use ($user) {
                $message
                    ->to($user->email, $user->name)
                    ->subject(__('user.email_verify_subject'));
            }
        );

        return $user;
    }
}
