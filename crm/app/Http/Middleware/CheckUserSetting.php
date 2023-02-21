<?php

namespace App\Http\Middleware;

use App\Services\VetmanagerApi;
use Closure;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckUserSetting
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     * @throws GuzzleException
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            VetmanagerApi::checkUserSettings(
                auth()->user()->userSettingApi->key,
                auth()->user()->userSettingApi->url
            );
            return $next($request);
        } catch (\Exception $e) {
            return redirect('reset-api-key');
        }
    }
}
