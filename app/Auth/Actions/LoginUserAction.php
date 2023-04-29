<?php

namespace App\Auth\Actions;

use App\Providers\RouteServiceProvider;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Requests\Auth\LoginRequest;

class LoginUserAction
{
    use AsAction;

    public function handle(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
