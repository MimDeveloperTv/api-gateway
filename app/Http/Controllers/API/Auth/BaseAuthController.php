<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Passport\Client;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Illuminate\Http\Response;

class BaseAuthController extends AccessTokenController
{
    public function checkUserGroup(): Model
    {
        // validation mobile & password : coming soon
        $user = User::query()->where('phone', request('username'))->firstOrFail();
        $checkPassword = Hash::check(request('password'), data_get($user, 'password'));
        abort_unless($checkPassword, 401, UnauthorizedException::class);

        // check UserGroup
        $client = Client::query()->find(\request()->get('client_id'));
        $existUser = \App\Models\UserGroup::query()->where([
            'user_id'=> data_get($user,'id'),
            'group' => data_get($client,'name'),
        ])->exists();
        abort_unless($existUser, 401, UnauthorizedException::class);

        return $user;
    }

    public function makeToken($request): Response
    {
        return $this->issueToken($request);
    }
}
