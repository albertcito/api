<?php

namespace App\Logic\User;

use App\User as UserModel;
use App\Exceptions\MessageError;

class User
{
    public function authorize($idUser = 0)
    {
        $authorize = $this->isAuthorize($idUser);
        if ($authorize) return true;
        $error = __(
            'logic.authorize',
            ['errorCode' => $user->idUser . '-' . $idUser]
        );
        throw with(new MessageError($error));
    }

    public function isAuthorize($idUser = 0)
    {
        $user = \Auth::User();
        return ($user->idUser == 1) || ($user->idUser == $idUser);
    }
}
