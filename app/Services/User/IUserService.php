<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\IService;
use Illuminate\Support\Collection;

interface IUserService extends IService
{
    function findByUsername($username): User | null;
    function changePassword(int $id, array $param): User | null;
    function forgotPassword(string $email): mixed;//User | null
    function resetPassword(array $param): User | null;
    function getAllUsers(): Collection;
}
