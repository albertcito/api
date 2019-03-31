<?php

namespace App\Logic\Enum;

use App\Logic\Enum\Enum;

/**
 *  @author German Velasquez
 *  @date October 10, 2018
 */
class UserStatus extends Enum
{
    const _DEFAULT = 'Active';

    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';
    const BLOCKED = 'Blocked';
}
