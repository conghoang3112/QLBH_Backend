<?php

namespace App\Providers;

use App\Helpers\AuthorizationSubject;
use App\Helpers\Enums\UserRoles;
use App\Repositories\User\IUserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Hash;

class ApiUserProvider implements UserProvider
{
    private IUserRepository $userRepos;
    public function __construct(IUserRepository $userRepos)
    {
        $this->userRepos = $userRepos;
    }

    public function retrieveById($identifier)
    {
        $ret = AuthorizationSubject::getAnonymousUser();
        if (!in_array($identifier, [null, 0])) {
            if ($user = $this->userRepos->getSingleObject($identifier)->first()) {
                $ret->representFor($user);
                return $user;
            }
        }
        return $ret; //  anonymous user
    }

    public function retrieveByToken($identifier, $token)
    {
        $payload = AuthorizationSubject::parse($token);
        return $this->retrieveById($payload->sub);
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    public function retrieveByCredentials(array $credentials)
    {
        $anonymous = AuthorizationSubject::getAnonymousUser();
        // $type = $credentials['identifier_type'] ?? 'email';
        // if ($type == 'email') {
        //     $email = $credentials['email'] ?? '';
        //     if ($email == '') {
        //         return AuthorizationSubject::getAnonymousUser();
        //     }
        //     $user = $this->userRepos->findByEmail($email)->first();
        // } else if ($type == 'phone') {
        //     $phone = $credentials['phone'] ?? '';
        //     if ($phone == '') {
        //         return AuthorizationSubject::getAnonymousUser();
        //     }
        //     $user = $this->userRepos->findByPhone($phone)->first();
        // }
        $username = $credentials['username'] ?? null;
        if (empty($username)) return AuthorizationSubject::getAnonymousUser();
        $user = $this->userRepos->findByUsername($username);
        if (empty($user)) return null;

        # Check allows roles base on hook key
        // $allowRoles = $this->getAllowedRoles($credentials['hook']);
        // if (!in_array($user->group_id, $allowRoles)) return null;

        # Check password
        $password = $credentials['password'] ?? '';
        $uHashedPassword = $user->getAuthPassword();
        if (!Hash::check($password, $uHashedPassword)) return null;
        $sub = new AuthorizationSubject();
        $sub->representFor($user);
        return $sub;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $anonymous = AuthorizationSubject::getAnonymousUser();
        if ($user->getAuthIdentifier() == $anonymous->getAuthIdentifier())  return true;

        $password = $credentials['password'] ?? '';
        $uHashedPassword = $user->getAuthPassword();
        return Hash::check($password, $uHashedPassword);
    }

    public function getAllowedRoles(string $hook)
    {
        if (str_starts_with($hook, 'admin')) {
            return [UserRoles::ADMIN];
        }
        return [UserRoles::USER, UserRoles::AGENT];
    }
}
