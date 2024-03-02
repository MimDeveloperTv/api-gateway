<?php

namespace App\Http\Controllers\API\Auth\Pass;

use App\Enum\Fields;
use App\Http\Controllers\API\Auth\BaseAuthController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Passport\Client;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Response;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class AuthController extends BaseAuthController
{
    public function login(ServerRequestInterface $request): Response
    {
        $user = $this->checkUserGroup();
        return $this->makeToken($request);
    }
    public function register(Request $request)
    {
    }
    public function logout (Request $request)
    {
        /* @var $user User */
        $user =  auth()->user();
        $userAccessToken = $user->token();
        $userAccessTokenId = $userAccessToken->getKey();
        $userAccessToken->revoke();
        $userAccessToken->refresh()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
            'token_id' => $userAccessTokenId,
        ]);

        /*
        // Revoke an access token...
          app(TokenRepository::class)->revokeAccessToken($tokenId);
        // Revoke all of the token's refresh tokens...
           app(RefreshTokenRepository::class)->revokeRefreshTokensByAccessTokenId($tokenId);
        */

    }
}
