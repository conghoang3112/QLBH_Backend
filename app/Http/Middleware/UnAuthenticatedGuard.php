<?php

namespace App\Http\Middleware;

use App\Exceptions\Business\ActionFailException;
use App\Helpers\AuthorizationSubject;
use App\Helpers\Enums\ErrorCodes;
use App\Helpers\Enums\UserRoles;
use App\Helpers\Responses\HttpStatuses;
use App\Models\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UnAuthenticatedGuard extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
            $user = auth()->user();
            $blocked = false;
            if ($user instanceof User) {
                $blocked = true;
            } elseif ($user instanceof AuthorizationSubject && !$user->isAnonymous()) {
                $blocked = true;
            }

            if ($blocked) throw new ActionFailException(ErrorCodes::ERR_INVALID_URL);
        } catch (\Exception $ex) {
            // TODO: Do nothing
        }
        return $next($request);
    }
}
