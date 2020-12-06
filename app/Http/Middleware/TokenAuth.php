<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Transformers\MessageTransformer;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        $authHeader = $request->header('Authorization', '');
        if (
            preg_match(
                '/^Bearer\s+(?<token>\S+)$/',
                $authHeader,
                $matches
            ) &&
            $matches['token'] === config('app.auth_token')
        ) {
            return $next($request);
        }

        return fractal()->item(__('unauthorized'))
            ->transformWith(new MessageTransformer())
            ->respond(Response::HTTP_UNAUTHORIZED);
    }
}
