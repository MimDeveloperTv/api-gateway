<?php

namespace App\Http\Controllers\API\Auth\Pass;

use App\Enum\Fields;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Response;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class AuthController extends AccessTokenController
{
    public function login(ServerRequestInterface $request): Response
    {
        // validation mobile & password : coming soon
        return $this->issueToken($request);
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
