<?php

namespace App\Auth\Actions;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;

class RegisteredUserAction
{
    use AsAction;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }


    public function asController(ActionRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));


        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
