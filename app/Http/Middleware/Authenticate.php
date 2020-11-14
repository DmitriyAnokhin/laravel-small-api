<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Exception;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     * @throws Exception
     */
    protected function redirectTo($request)
    {
        /*
        if (!$request->expectsJson()) {
            return route('login');
        }
        */

        throw new Exception('Пользователь не авторизован', 401);
    }
}
