<?php

namespace App\Logic;

use App\Model\UserToken;

class FrontendURL
{
    public static function validEmail($idUser) : string
    {
        $token = UserToken::addValidEmail($idUser);
        $frontendLogin = \Config::get('frontend.URL.active-email');
        return sprintf($frontendLogin, $token);
    }

    public static function resetPass($idUser) : string
    {
        $token = UserToken::addResetPass($idUser);
        $frontendLogin = \Config::get('frontend.URL.reset-pass');
        return sprintf($frontendLogin, $token);
    }

    public static function zip() : string
    {
        return \Config::get('frontend.URL.zip');
    }
}
