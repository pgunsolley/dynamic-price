<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\PasswordConfirmationForm;
use App\Form\EmailForm;
use App\Form\UserForm;
use App\Form\UserForm\Enum\Status;
use App\Model\Entity\User;
use App\Service\JwtService;
use App\Service\UsersMailerService;
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

    private function redirectToLogin()
    {
        return $this->redirect(['_name' => 'users:login']);
    }

    public function initialize(): void
    {
        parent::initialize();

        $this->Authentication->allowUnauthenticated([
            'login',
            'register',
            'requestEmailVerification',
            'handleEmailVerification',
            'requestPasswordReset',
            'handlePasswordReset',
        ]);

        $this->loadComponent('RecaptchaV3.RecaptchaV3', [
            'actions' => [
                'register',
                'login',
                'requestPasswordReset',
            ],
        ]);
    }

    public function register(UsersMailerService $usersMailer)
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $this->Users->patchEntity(
                entity: $user,
                data: $this->request->getData(),
                options: [
                    'validate' => 'withPasswordConfirmation',
                ],
            );

            if ($this->Users->save($user)) {
                $this->sendVerificationEmail($usersMailer, $user);
                return $this->redirectToLogin();
            } else {
                $this->Flash->error(__('Unable to register new account'));
            }
        }

        $this->set(compact('user'));
    }

    public function requestEmailVerification(UsersMailerService $usersMailer, JwtService $jwt, string $token)
    {
        try {
            $jwtPayload = $jwt->decodePayload($token);
        } catch (ExpiredException) {
            $this->Flash->error(__('The link has expired'));
            return $this->redirectToLogin();
        } catch (Exception) {
            $this->Flash->error(__('Unable to process request'));
            return $this->redirectToLogin();
        }

        if (!$jwtPayload->check('scope', 'request_email_verification')) {
            return $this->redirectToLogin();
        }

        $submit = (int)$this->request->getQuery('submit');

        if ($submit === 1) {
            /** @var int|null $userId */
            $userId = $jwtPayload->get('sub');

            if (!is_int($userId)) {
                return $this->redirectToLogin();
            }

            /** @var \App\Model\Entity\User|null $user */
            $user = $this->Users->get(primaryKey: $userId, finder: 'emailNotVerified');

            if ($user === null) {
                $this->Flash->error(__('Unable to send email verification'));
                return $this->redirectToLogin();
            }

            $usersMailer->emailVerification($user);
            $this->Flash->success(__('Verification email sent to {0}', $user->email));
            return $this->redirectToLogin();
        }
    }

    public function handleEmailVerification(JwtService $jwt, string $token)
    {
        try {
            $jwtPayload = $jwt->decodePayload($token);
        } catch (ExpiredException) {
            $this->Flash->error(__('The verification link has expired'));
            return $this->redirectToLogin();
        } catch (Exception) {
            $this->Flash->error(__('Unable to verify email'));
            return $this->redirectToLogin();
        }

        if (!$jwtPayload->check('scope', 'handle_email_verification')) {
            return $this->redirectToLogin();
        }

        /** @var int|null $userId */
        $userId = $jwtPayload->get('sub');

        if ($userId === null) {
            $this->Flash->error(__('Url is malformed - please try again'));
            return $this->redirectToLogin();
        }

        if ($this->Users->updateEmailVerified($userId)) {
            $this->Flash->success(__('Your account has been activated'));
        } else {
            $this->Flash->error(__('Something went wrong - please try again'));
        }

        return $this->redirectToLogin();
    }

    public function requestPasswordReset(UsersMailerService $usersMailer)
    {
        $form = new EmailForm();

        if ($this->request->is('post')) {
            if ($form->execute($this->request->getData())) {
                /** @var string $email The validated email field value */
                $email = $form->getData('email');

                /** @var \App\Model\Entity\User|null */
                $user = $this->Users->find('byEmail', email: $email)->first();

                if ($user) {
                    $usersMailer->resetPassword($user);
                    $this->Flash->success(__('A password reset email has been sent to {0}', $email));
                    return $this->redirectToLogin();
                } else {
                    $this->Flash->error(__('No account for {0}', $email));
                }
            } else {
                $this->Flash->error(__('Invalid email'));
            }
        }

        $this->set(compact('form'));
    }

    public function handlePasswordReset(JwtService $jwt, string $token)
    {
        try {
            $jwtPayload = $jwt->decodePayload($token);
        } catch (ExpiredException) {
            $this->Flash->error(__('The password reset link has expired'));
            return $this->redirectToLogin();
        } catch (Exception) {
            $this->Flash->error(__('Unable to reset password'));
            return $this->redirectToLogin();
        }

        if (!$jwtPayload->check('scope', 'handle_password_reset')) {
            return $this->redirectToLogin();
        }

        /** @var int|null $userId */
        $userId = $jwtPayload->get('sub');

        if ($userId === null) {
            $this->Flash->error(__('Url is malformed - please try again'));
            return $this->redirectToLogin();
        }

        $form = new PasswordConfirmationForm();

        if ($this->request->is('post')) {
            if ($form->execute($this->request->getData())) {
                $password = $form->getData('password');

                if ($this->Users->updatePassword($userId, $password)) {
                    $this->Flash->success(__('Password has been reset'));
                    return $this->redirectToLogin();
                }

                $this->Flash->error(__('Unable to reset password'));
            } else {
                $this->Flash->error(__('Password is invalid'));
            }
        }

        $this->set(compact('form'));
    }

    public function login(JwtService $jwt)
    {
        $form = new UserForm();

        if ($this->request->is('post')) {
            // TODO: Check RecaptchaV3 client response
            dd($this->request->getData());

            /** @var string $email */
            $email = $this->request->getData('email');

            if ($form->execute($this->request->getData())) {
                /** @var \App\Model\Entity\User $user */
                $user = $form->getUser();

                if ($user->email_verified) {
                    // Successful login
                    $this->Authentication->setIdentity($user);
                    return $this->redirect([]); // TODO: Redirect to landing
                }

                return $this->redirect([
                    '_name' => 'users:requestEmailVerification',
                    $jwt->encode(
                        user: $user,
                        additionalClaims: [
                            'scope' => 'request_email_verification',
                        ],
                    ),
                ]);
            }

            match ($form->getStatus()) {
                Status::ValidationError => $this->Flash->error(__('Invalid email or password')),
                Status::UserNotFound => $this->Flash->error(__('No account for {0}', $email)),
                Status::InvalidPassword => $this->Flash->error(__('Password is incorrect')),
                Status::Pending => $this->Flash->error(__('Unable to process request')),
            };
        }

        $this->set(compact('form'));
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirectToLogin();
    }
}
