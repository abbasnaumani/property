<?php

namespace App\Services;

use App\Enums\ApiResponseEnum;
use App\Models\User;
use App\Notifications\VerifyEmail;
use App\Services\BaseService\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class AuthService extends BaseService
{
    /**
     * @param User $user
     *
     *  Method for sending Verification code to user email
     */
    public function sendVerificationCode(User $user)
    {
        $verification = $this->updateOrCreateVerificationCode(['user_id' => $user->id, 'type' => 'reset_password', 'type_value' => $user->email]);
        $verificationCode = $verification->code ?? null;
        if ($verificationCode) {
            Notification::send($user, new VerifyEmail(['token' => $verificationCode]));
            $encodedToken = $this->customEncode($user->email . '|' . $verification->id);
            $this->setApiSuccessMessage(trans('auth.email_sent'), ['token' => $encodedToken]);
        } else {
            $this->setApiErrorMessage(trans('auth.verify_email_not_sent'));
        }
    }

    /**
     * @param Request $request
     *
     *  Method for Verify Email Token
     *
     */
    public function resetPassword(Request $request)
    {
        $user = $request->getUserFromRequest();
        $this->verifyVerificationCode(['user_id' => $user->id, 'id' => $request->getUserVerifyId(), 'code' => $request->verification_code]);
        if ($this->isTokenVerified) {
            $user->password = Hash::make($request->password);
            $user->save();
            $this->setApiSuccessMessage(trans('auth.password_updated'));
        }
    }
}
