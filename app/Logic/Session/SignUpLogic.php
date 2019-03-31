<?php

namespace App\Logic\Session;

use Illuminate\Http\Request;
use App\Exceptions\MessageError;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\{
    Auth,
    DB
};
use App\Model\{
    User,
    UserToken
};

class SignUpLogic
{
    public static function signUp($name, $email, $password)
    {
        $userExist = User::where(['email' => $email])->count();
        if ($userExist > 0) {
            throw with(new MessageError('The user already is registered'));
        }

        try {
            DB::beginTransaction();
            $user = User::create([
                'email' => $email,
                'password' => bcrypt($password),
                'name' => $name,
            ])->fresh();

            $token = bin2hex(random_bytes(30));
            $userToken = UserToken::create([
                'idUser' => $user->idUser,
                'token'  => $token,
                'type'   => 'validEmail',
                'idUserCreate' => $user->idUser
            ])->fresh();
            DB::commit();

            $link = env('CUSTOMER_URL'). 'login?token=' . $token;
            \Mail::send(
                'emails.activation',
                [
                    'user' => $user,
                    'link' => $link
                ],
                function ($message) use ($user) {
                    $message
                        ->to($user->email, $user->name)
                        ->subject('Verify your email DevicePixel.com');
                }
            );
        } catch (\Exception $error) {
            DB::rollback();
            throw new \Exception($error);
        }

        return $user;
    }
}
