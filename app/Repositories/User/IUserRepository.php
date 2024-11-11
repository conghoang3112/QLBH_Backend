<?php

namespace App\Repositories\User;

use App\Helpers\Common\MetaInfo;
use App\Models\User;
use App\Repositories\IRepository;
use Illuminate\Support\Collection;

interface IUserRepository extends IRepository
{
    function findByUsername($username): User | null;
    function findByEmail($email): User | null;
    function changePassword(array $form, ?MetaInfo $meta = null, string $idColumnName = 'id'): User | null;

    function getAllUsers(): Collection;
}
