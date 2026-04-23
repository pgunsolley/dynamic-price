<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\User;
use Cake\Http\Exception\NotImplementedException;
use Cake\Mailer\Mailer;

class UsersMailer extends Mailer
{
    public function emailVerification(User $user, string $token): void
    {
        $this
            ->setEmailFormat('text')
            ->setTo($user->email)
            ->setSubject('Complete your registration')
            ->setViewVars('token', $token);
    }

    public function resetPassword(User $user, string $token): void
    {
        throw new NotImplementedException();
    }
}