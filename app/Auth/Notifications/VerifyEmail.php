<?php

declare(strict_types=1);

namespace App\Auth\Notifications;

use Carbon\Carbon;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

/**
 * Class VerifyEmail.
 */
class VerifyEmail extends \Illuminate\Auth\Notifications\VerifyEmail
{
    /**
     * @param mixed $objUser
     *
     * @return MailMessage
     */
    public function toMail($objUser): MailMessage
    {
        return (new MailMessage())
            ->subject(Lang::getFromJson('Verify Email Address'))
            ->line(Lang::getFromJson('Please click the button below to verify your email address.'))
            ->action(
                Lang::getFromJson('Verify Email Address'),
                $this->verificationUrl($objUser)
            )
            ->line(Lang::getFromJson('If you did not create an account, no further action is required.'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $objUser
     *
     * @return string
     */
    protected function verificationUrl($objUser): string
    {
        return URL::temporarySignedRoute(
            'api/auth/user/register',
            Carbon::now()->addMinutes(60),
            ['id' => $objUser->getKey()]
        );
    }
}
