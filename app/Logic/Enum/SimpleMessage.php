<?php

namespace App\Logic\Enum;

use App\Logic\Enum\Enum;

class SimpleMessage extends Enum
{
    const _DEFAULT = 'success';

    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';
}
