<?php

namespace App\Logic\Session;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\MessageError;
use App\Model\User;
use App\Logic\Enum\UserStatus;

class LoginLogic
{
    /**
     * Login a user
     * @param  string  $email    user email
     * @param  string  $password user password
     * @param  boolean $remember to remmeber or not the session
     * @return User return a user model instance
     */
    public static function user($email, $password, $remember = false)
    {
        $user = $this->getUser($email, $password);
        Auth::login($user, $remember);
        return $user;
    }

    /**
     * Login a user with apu token passport
     * @param  string  $email    user email
     * @param  string  $password user password
     * @return User return a user model instance
     */
    public function api($email, $password)
    {
        $user = $this->getUser($email, $password);
        $user['accessToken'] = $user->createToken('DevicePixel.com')->accessToken;
        return $user;
    }

    private function getUser($email, $password)
    {
        if (Auth::check()) {
            throw with(new MessageError(__('user.logged_already')));
        }

        $user = User::where(['email' => $email])->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw with(new MessageError(__('user.login_wrong')));
        }

        if ($user->status != UserStatus::ACTIVE) {
            throw with(new MessageError(__('user.no_active')));
        }

        return $user;
    }
}
