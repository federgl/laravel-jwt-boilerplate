<?php

declare(strict_types=1);

namespace App\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class SellerResetPasswordNotification.
 */
class UserResetPasswordNotification extends Notification
{
    use Queueable;

    // Token handler
    public $strToken;

    /**
     * Create a new notification instance.
     *
     * @param mixed $strToken
     */
    public function __construct($strToken)
    {
        $this->strToken = $strToken;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $objUser
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($objUser): MailMessage
    {
        return (new MailMessage())
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', \url('api/auth/user/forgot/password/reset', $this->strToken))
            ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }
}
