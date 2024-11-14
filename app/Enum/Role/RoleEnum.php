<?php

namespace App\Enum\Role;

use App\Enum\BaseEnum;

class RoleEnum extends BaseEnum
{
    public const SUPER_ADMIN = 'super_admin';
    public const MANAGER     = 'manager';
    public const EMPLOYEE    = 'employee';
}
