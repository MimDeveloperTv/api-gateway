<?php

namespace App\Http\Controllers\API\Auth\Basic;

use App\Enum\UserGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends AccessTokenController
{
    public function login(ServerRequestInterface $request)
    {
        // validation mobile & password : coming soon
        $user = User::query()->where('phone', request('username'))->first()->toArray();
        $checkPassword = Hash::check(request('password'), data_get($user, 'password'));
        abort_unless($checkPassword, 401, UnauthorizedException::class);

        $tokenOperation = $this->issueToken($request);
        $token = json_decode($tokenOperation->content(), true);
        $accessToken = data_get($token, 'access_token');

        $response = [
            'response_code' => 'auth_login_200',
            'message' => 'successfully logged in',
            'content' => [
                'token' => data_get($token, 'access_token'),
                'user' => [
                    'id' => data_get($user, 'id'),
                    'phone' => data_get($user, 'phone'),
                    'email' => data_get($user, 'email'),
                    'first_name' => data_get($user, 'first_name'),
                    'last_name' => data_get($user, 'last_name'),
                    'fullname' => data_get($user, 'first_name') . data_get($user, 'last_name'),
                    'avatar' => data_get($user, 'avatar'),
                ]
            ],

        ];
        return response($response, 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function validateToken(Request $request)
    {
        /* @var $user User */
        $user = auth()->user();
        $token = $request->user()->token();
        $client = $token->client()->first()->toArray();
        $response = [
            'data' => [
                'user' => [
                    'id' => data_get($user, 'id'),
                    'phone' => data_get($user, 'phone'),
                    'email' => data_get($user, 'email'),
                    'first_name' => data_get($user, 'first_name'),
                    'last_name' => data_get($user, 'last_name'),
                    'fullname' => data_get($user, 'first_name') . data_get($user, 'last_name'),
                    'avatar' => data_get($user, 'avatar'),
                    'client_id' => data_get($token, 'client_id'),
                    'userGroup' => UserGroup::get(data_get($client, 'name')),
                ],
            ]
        ];
        return response($response, 200);
    }
}
