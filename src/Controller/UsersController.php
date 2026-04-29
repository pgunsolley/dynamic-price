<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\ConfirmPasswordForm;
use App\Form\EmailForm;
use App\Form\UserForm;
use App\Form\UserForm\Enum\Status;
use App\Model\Entity\User;
use App\Service\JwtService;
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
        $form = new UserForm();

        if ($this->request->is('post')) {
            $form->execute($this->request->getData());

            /** @var string $email */
            $email = $form->getData('email');

            /** @var \App\Model\Entity\User|null */
            $user = $form->getUser();

            if ($user?->email_verified) {
                $this->Flash->error(__('Account is already verified'));
                // TODO: return redirect to landing
            }

            match ($form->getStatus()) {
                Status::Success => $this->sendVerificationEmail($usersMailer, $user),
                Status::ValidationError => $this->Flash->error(__('Invalid email or password')),
                Status::UserNotFound => $this->Flash->error(__('No account for {0}', $email)),
                Status::InvalidPassword => $this->Flash->error(__('Password is incorrect')),
                Status::Pending => $this->Flash->error(__('Unable to process request')),
            };
        }

        $this->set(compact('form'));
    }

    public function handleEmailVerification(JwtService $jwt, string $token)
    {
        try {
            $jwtPayload = $jwt->decodePayload($token);
        } catch (ExpiredException) {
            $this->Flash->error(__('The verification link has expired'));
        } catch (Exception) {
            $this->Flash->error(__('Unable to verify email'));
        } finally {
            return $this->redirect(['_name' => 'users:requestEmailVerification']);
        }

        if (!$jwtPayload->check('scope', 'verify_email')) {
            $this->Flash->error(__('Invalid url'));
            return $this->redirect(['_name' => 'users:requestEmailVerification']);
        }

        /** @var int|null $userId */
        $userId = $jwtPayload->get('sub');

        if ($userId === null) {
            $this->Flash->error(__('Unable to verify email'));
            return $this->redirect(['_name' => 'users:requestEmailVerification']);
        }

        /** @var \App\Model\Entity\User|null */
        $user = $this->Users->get(primaryKey: $userId, finder: 'emailNotVerified');

        if ($user) {
            $user->set('email_verified', true);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Email has been verified'));
                // TODO: Log user in and redirect
            }
        }

        $this->Flash->error(__('Something went wrong - please try again'));
        return $this->redirect(['_name' => 'users:requestEmailVerification']);
    }

    public function requestPasswordReset(UsersMailerService $usersMailer, ?string $token = null)
    {
        $emailForm = new EmailForm();

        if ($this->request->is('post')) {
            if ($emailForm->execute($this->request->getData())) {
                /** @var string $email */
                $email = $emailForm->getData('email');

                /** @var \App\Model\Entity\User|null */
                $user = $this->Users->find('byEmail', email: $email)->first();

                if ($user) {
                    $usersMailer->resetPassword($user);
                    $this->Flash->success(__('An email has been sent to {0}', $email));
                } else {
                    $this->Flash->error(__('No account for {0}', $email));
                }
            } else {
                $this->Flash->error(__('Invalid email'));
            }
        }

        $this->set(compact('emailForm'));
    }

    public function handlePasswordReset(JwtService $jwt, string $token)
    {
        try {
            $jwtPayload = $jwt->decodePayload($token);
        } catch (ExpiredException) {
            $this->Flash->error(__('The password reset link has expired'));
        } catch (Exception) {
            $this->Flash->error(__('Unable to reset password'));
        } finally {
            return $this->redirect(['_name' => 'users:requestPasswordReset']);
        }

        if (!$jwtPayload->check('scope', 'reset_password')) {
            $this->Flash->error(__('Invalid url'));
            return $this->redirect(['_name' => 'users:requestPasswordReset']);
        }

        /** @var int|null $userId */
        $userId = $jwtPayload->get('sub');

        if ($userId === null) {
            $this->Flash->error(__(''));
            return $this->redirect(['_name' => 'users:requestPasswordReset']);
        }

        $form = new ConfirmPasswordForm();

        if ($this->request->is('post')) {
            if ($form->execute($this->request->getData())) {
                /** @var string $password */
                $password = $form->getData('password');

                /** @var \App\Model\Entity\User|null $user */
                $user = $this->Users->get($userId);

                if ($user) {
                    /** @var string $email */
                    $email = $user->get('email');

                    $user->set('password', $password);

                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Password has been reset for {0}', $email));
                        return $this->redirect(['_name' => 'users:login']);
                    }

                    $this->Flash->error(__('Unable to reset password for {0}', $email));
                    return $this->redirect(['_name' => 'users:requestPasswordReset']);
                } else {
                    // Should not likely occur unless a user account is deleted between the time
                    // a user requests a pasword reset email and follows the link from the email
                    $this->Flash->error(__('Account not found'));
                    return $this->redirect(['_name' => 'users:requestPasswordReset']);
                }
            } else {
                $this->Flash->error(__('Password is invalid'));
            }
        }

        $this->set(compact('form'));
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
