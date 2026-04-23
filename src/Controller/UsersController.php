<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\EmailForm;
use App\Form\Enum\UserFormResult;
use App\Form\UserForm;
use App\Model\Entity\User;
use App\Service\UsersJwtService;
use App\Service\UsersMailerService;
use Cake\Http\Exception\NotImplementedException;
use Firebase\JWT\ExpiredException;
use Exception;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    private function sendVerificationEmail(UsersMailerService $usersMailer, User $user): void
    {
        $usersMailer->emailVerification($user);
        $this->Flash->success(__('A verification email has been sent to {0}', $user->email));
    }

    public function register(UsersMailerService $usersMailer)
    {
        $user = $this->Users->newEmptyEntity();
        $verificationEmailSent = false;

        if ($this->request->is('post')) {
            $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->sendVerificationEmail($usersMailer, $user);
                $verificationEmailSent = true;
            } else {
                $this->Flash->error(__('Unable to register new account'));
            }
        }

        $this->set(compact('user'));
        $this->set(compact('verificationEmailSent'));
    }

    public function requestEmailVerification(UsersMailerService $usersMailer)
    {
        $userForm = new UserForm();

        if ($this->request->is('post')) {
            $userForm->execute($this->request->getData());
            $email = $userForm->getData('email');
            $user = $userForm->getUser();

            if ($user?->email_verified) {
                $this->Flash->error(__('Account is already verified'));
                // TODO: return redirect to landing
            }

            match ($userForm->getResult()) {
                UserFormResult::Success             => $this->sendVerificationEmail($usersMailer, $user),
                UserFormResult::ValidationError     => $this->Flash->error(__('Invalid email or password')),
                UserFormResult::UserNotFound        => $this->Flash->error(__('No account for {0}', $email)),
                UserFormResult::InvalidPassword     => $this->Flash->error(__('Password is incorrect')),
                UserFormResult::Pending             => $this->Flash->error(__('Unable to process request')),
            };
        }

        $this->set(compact('userForm'));
    }

    public function handleEmailVerification(UsersJwtService $usersJwt, string $token)
    {
        try {
            $userId = $usersJwt->extractUserId($token);
        } catch (ExpiredException) {
            $this->Flash->error(__('The verification link has expired'));
        } catch (Exception) {
            $this->Flash->error(__('Unable to verify email'));
        } finally {
            return $this->redirect(['_name' => 'users:requestEmailVerification']);
        }

        $user = $this->Users->get(primaryKey: $userId, finder: 'emailNotVerified');

        if ($user) {
            $user->set('email_verified', true);
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Email has been verified'));
            } else {
                $this->Flash->error(__('Unable to update user account'));
            }
        } else {
            $this->Flash->error(__('Email is already verified'));
        }

        // TODO: Log user in and redirect to landing (setup AuthenticationServiceProvider)
    }

    // TODO: Refactor this into requestPasswordReset and resetPassword
    public function requestPasswordReset(UsersMailerService $usersMailer, ?string $token = null)
    {
        /*
        TODO: Setup form

        create ResetPasswordForm that extends EmailForm?
        create reset password email
        create another action to handle the reset url? Or handle in this action?

        */
        $emailForm = new EmailForm();

        if ($this->request->is('post') && $emailForm->execute($this->request->getData())) {
            // TODO: Use UsersMailerService to send email
        }

        $this->set(compact('emailForm'));
    }

    public function handlePasswordReset()
    {
        throw new NotImplementedException();
    }

    public function login()
    {
        throw new NotImplementedException();
    }

    public function logout()
    {
        throw new NotImplementedException();
    }
}
