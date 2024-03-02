<?php

namespace App\Http\Controllers\API\Auth\Basic;

use App\Enum\UserGroup;
use App\Http\Controllers\API\Auth\BaseAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends BaseAuthController
{
    public function login(ServerRequestInterface $request)
    {
        $user =  $this->checkUserGroup();
        $tokenOperation = $this->makeToken($request);
        $token = json_decode($tokenOperation->content(), true);

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
