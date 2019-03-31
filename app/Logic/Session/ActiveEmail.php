<?php

namespace App\Logic\Session;

use Illuminate\Support\Facades\URL;
use App\Exceptions\MessageError;

use App\Logic\Enum\TokenType;
use App\Model\Token;

class ActiveEmail
{
    public static function activate($tokenString)
    {
        $email = \Config::get('constants.supportEmail');
        $msgError = __(
            'token.validEmailExpired',
            ['email' => $email]
        );

        $token = Token::getToken($tokenString, TokenType::VALIDEMAIL);
        if (!$token) {
            throw with(new MessageError($msgError));
        }

        //save user valid email
        $user = $token->users()->first();
        $user->validEmail = 1;
        $user->save();

        //Save token as used
        $token->usedAt = date('Y-m-d H:i:s');
        $token->save();

        //create token to loggin immediately
        $user['accessToken'] = $user->createToken('DevicePixel.com')->accessToken;
        return $user;
    }
}
