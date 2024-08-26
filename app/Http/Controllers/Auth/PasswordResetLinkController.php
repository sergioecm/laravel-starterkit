<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Fortify;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request): Responsable
    {
        $x=$request->validate([Fortify::email() => 'required|email']);
//dd(print_r($x,true));
//dd(print_r($request,true));
//        $validated = $request->validated();
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        try {
            $status = $this->broker()->sendResetLink(
                $request->only(Fortify::email())
            );
        } catch(\Exception $e){
            $e->getMessage();
        }


        return app(SuccessfulPasswordResetLinkRequestResponse::class,
            ['status' => Password::RESET_LINK_SENT]
        );
//        return $status == Password::RESET_LINK_SENT
//            ? app(SuccessfulPasswordResetLinkRequestResponse::class, ['status' => $status])
//            : app(FailedPasswordResetLinkRequestResponse::class, ['status' => $status]);
    }

    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }

}
