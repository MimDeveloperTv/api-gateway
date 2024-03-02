<?php

namespace App\Http\Controllers\API\Auth\Basic;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends AccessTokenController
{
    public function login(ServerRequestInterface $request)
    {
       // validation mobile & password : coming soon
        $user = User::query()->where('phone',request('username'))->first()->toArray();
        $checkPassword = Hash::check(request('password'),data_get($user,'password'));
        abort_unless($checkPassword,401,UnauthorizedException::class);

        $tokenOperation =  $this->issueToken($request);
        $token = json_decode($tokenOperation->content(),true);
        $accessToken = data_get($token,'access_token');

        $response = [
            'response_code' => 'auth_login_200',
            'message' => 'successfully logged in',
            'content' => [
                'token' => data_get($token,'access_token'),
                'user' =>  [
                    'first_name' =>  data_get($user,'first_name'),
                    'last_name' =>  data_get($user,'last_name'),
                    'fullname' =>  data_get($user,'first_name') . data_get($user,'last_name'),
                    'email' =>  data_get($user,'email'),
                    'avatar' =>  data_get($user,'avatar'),
                ]
            ],

        ];
        return response($response, 200);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function validateToken(Request $request)
    {
        $token = $request->user()->token();
        $response = ['message' => 'validated'];
        return response($response, 200);
    }
}
