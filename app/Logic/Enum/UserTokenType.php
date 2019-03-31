<?php

namespace App\Logic\Enum;

use App\Logic\Enum\Enum;

class UserTokenType extends Enum
{
    const _DEFAULT = 'forgotPass';

    const VALIDEMAIL = 'validEmail';
    const FORGOTPASS = 'forgotPass';
}
