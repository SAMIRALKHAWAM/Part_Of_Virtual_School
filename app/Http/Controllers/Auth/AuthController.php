<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\RepositoryClass;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{

    public function __construct(public RepositoryClass $repositoryClass)
    {
    }

    public function Login(LoginRequest $request)
    {
        $arr = Arr::only($request->validated(), ['email', 'password']);
        $where = ['email' => $arr['email']];
        $actor = $this->repositoryClass->ShowAll(Actor::class, $where)->first();
        if (!Hash::check($arr['password'], $actor->password)) {
            throw new NotFoundHttpException(__('auth.ActorNotFound'));
        }
        $token = $actor->createToken('ActorSeeder')->plainTextToken;
        $actor['token'] = $token;
        return \SuccessData(__('auth.LoginSuccessfully'), new LoginResource($actor));
    }

    public function Logout()
    {
        $actor = \auth('actor')->user();
        if (!$actor) {
            throw new NotFoundHttpException(__('auth.ActorLogoutError'));
        }
        $actor->tokens()->delete();
        return \Success(__('auth.LogoutSuccessfully'));
    }


}
