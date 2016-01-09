<?php

namespace CodeDelivery\Http\Middleware;

use Closure;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class OAuthCheckRole
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository= $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $id = Authorizer::getResourceOwnerId();
        $user = $this->userRepository->find($id);
        if($user->role  != $role) abort(403, 'Access Forbiden');
        return $next($request);
    }
}