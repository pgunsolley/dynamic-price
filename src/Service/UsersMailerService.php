<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\User;
use Cake\Mailer\MailerAwareTrait;

class UsersMailerService
{
    use MailerAwareTrait;

    public function __construct(private JwtService $usersJwt)
    {
    }

    public function emailVerification(User $user): void
    {
        $jwt = $this->usersJwt->encode(
            user: $user,
            additionalClaims: [
                'scope' => 'handle_email_verification',
            ],
        );

        $this->getMailer('Users')->send('emailVerification', [$user, $jwt]);
    }

    public function resetPassword(User $user): void
    {
        $jwt = $this->usersJwt->encode(
            user: $user,
            additionalClaims: [
                'scope' => 'handle_password_reset',
            ],
        );

        $this->getMailer('Users')->send('resetPassword', [$user, $jwt]);
    }
}