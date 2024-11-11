<?php

namespace App\Services\Permission;

use App\Models\Permission;
use App\Services\IService;

interface IPermissionService extends IService
{
    function findBySlug($slug): Permission | null;
}
