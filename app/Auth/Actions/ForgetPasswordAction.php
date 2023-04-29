<?php

namespace App\Auth\Actions;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class ForgetPasswordAction
{
    use AsAction;

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }


    public function handle(ActionRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
