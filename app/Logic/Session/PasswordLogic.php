<?php

namespace App\Logic\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\MessageError;
use App\Logic\FrontendURL;
use App\Logic\Enum\TokenType;
use App\Model\{
    User,
    Token
};

class PasswordLogic
{
    /**
     * The user reset its password and login in the same time
     * @param string $token    token
     * @param string $password new password
     * @return User eloquent type
     */
    public static function resetLost($tokenString, $password)
    {
        $email = \Config::get('constants.supportEmail');
        $msgError = __(
            'auth.validEmailExpired',
            ['email' => $email]
        );
        $token = Token::getToken($tokenString, TokenType::FORGOTPASS);
        if (!$token) {
            throw with(new MessageError($msgError));
        }
        //Mark token as used
        $token->usedAt = date('Y-m-d H:i:s');
        $token->save();

        $user = $token->users()->first();
        $user->password = bcrypt($password);
        if (!$user->validEmail) {
            $user->validEmail = 1;
        }
        $user->save();
        $user['accessToken'] = $user->createToken('DevicePixel.com')->accessToken;
        return $user;
    }
    /**
     * The function send a email to the user to reset its password
     * @param  string $email [description]
     * @return array type GraphQL
     */
    public static function emailToken($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            throw with(new MessageError(__('user.email_not_found')));
        }

        $link = FrontendURL::resetPass($user->idUser);
        $supportEmail = \Config::get('constants.supportEmail');
        \Mail::send(
            'emails.forgotPass',
            [
                'name' => $user->name,
                'link' => $link,
                'supportEmail' => $supportEmail
            ],
            function ($message) use ($user) {
                $message
                    ->to($user->email, $user->name)
                    ->subject(__('user.reset_pass_subject'));
            }
        );

        return  [
            'message' => __('user.reset_pass_message'),
            'type' => 1
        ];
    }
}
