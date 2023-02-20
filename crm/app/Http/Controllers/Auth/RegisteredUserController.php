<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChengeUserSettingApi;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Models\UserSettingApi;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request)
    {
        $validated = $request->safe()->only(['name', 'email', 'password']);
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        UserSettingApi::create($request->safe()->only(['url', 'key']));

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function editUserSettindApi(ChengeUserSettingApi $request)
    {
        $validated = $request->validated();
        $userSettingApi = UserSettingApi::find(auth()->user()->id);
        $userSettingApi->fill($validated);
        $userSettingApi->save();

        return redirect(RouteServiceProvider::HOME);
    }
}
