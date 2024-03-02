<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckClientSecret
{
    public const CONFIG_CLIENT_SECRET_KEY = 'auth.oauth.clients.users.secret';
    public const CONFIG_CLIENT_ID_KEY = 'auth.oauth.clients.users.id';
    public const CLIENT_SECRET_KEY = 'client_secret';
    public const CLIENT_ID_KEY = 'client_id';
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientId = $request->input(self::CLIENT_ID_KEY);
        $allowedSecretClientId = config( self::CONFIG_CLIENT_ID_KEY);
        $isExistClientSecret =  $request->input(self::CLIENT_SECRET_KEY);
        if(empty($isExistClientSecret) && $clientId == $allowedSecretClientId)
        {
            $request->merge([ self::CLIENT_SECRET_KEY => config(self::CONFIG_CLIENT_SECRET_KEY)]);
        }

        return $next($request);
    }
}
