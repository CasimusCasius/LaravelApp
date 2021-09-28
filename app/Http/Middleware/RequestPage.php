<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RequestPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isPageFilled = $request->filled('page');

        if ($isPageFilled && $request->input('page') <= 0)
        {
            $request->replace(['page' => '1']);
        }

        return $next($request);
    }
}
