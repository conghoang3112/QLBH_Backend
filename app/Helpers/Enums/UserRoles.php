<?php

namespace App\Helpers\Enums;

use BenSampo\Enum\Enum;

class UserRoles extends Enum
{
    const ANONYMOUS = 'anonymous';
    
    const ADMIN = 'admin';
    const AGENT = 'agent';
    const USER = 'user';
    const DRAFT = 'draft';
}
