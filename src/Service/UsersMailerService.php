<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\User;
use Cake\Http\Exception\NotImplementedException;
use Cake\Mailer\MailerAwareTrait;

class UsersMailerService
{
    use MailerAwareTrait;

    public function __construct(private UsersJwtService $usersJwt)
    {
    }

    public function emailVerification(User $user): void
    {
        $this->getMailer('Users')->send('register', [$user, $this->usersJwt->encode($user)]);
    }

    public function resetPassword(User $user): void
    {
        throw new NotImplementedException();
    }
}