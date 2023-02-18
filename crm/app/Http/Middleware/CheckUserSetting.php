<?php

namespace App\Http\Middleware;

use App\Services\VetmanagerApi;
use Closure;
use Illuminate\Http\Request;

class CheckUserSetting
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (VetmanagerApi::checkUserSattings(auth()->user()->userSettingApi->key, auth()->user()->userSettingApi->url)) {
                return $next($request);
            }
        } catch (\Exception $e) {
            echo 'Выброшено исключение: Неправильный Url или ApiKey ',  $e->getMessage(), "\n";
            //return redirect('reset-api-key');
        }
    }
}
