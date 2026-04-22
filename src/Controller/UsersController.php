<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\EmailForm;
use App\Model\Entity\User;
use App\Service\UsersJwtService;
use App\Service\UsersMailerService;
use Cake\Http\Exception\NotImplementedException;
use Cake\Http\Response;
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

        if ($this->request->is('post')) {
            $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->sendVerificationEmail($usersMailer, $user);
            } else {
                $this->Flash->error(__('Unable to register new account'));
            }

            return $this->redirect(['_name' => 'users:resendVerificationEmail']);
        }

        $this->set(compact('user'));
    }

    public function resendVerificationEmail(UsersMailerService $usersMailer)
    {
        // TODO: Consider requiring a password .. probably a good idea bud
        $emailForm = new EmailForm();

        if ($this->request->is('post')) {
            if ($emailForm->execute($this->request->getData())) {
                $email = $emailForm->getData('email');
                $user = $this
                    ->Users
                    ->find('byEmail', email: $email)
                    ->first();

                if ($user === null) {
                    $this->Flash->error(__('Account does not exist for email {0}', $email));
                    return $this->redirect(['_name' => 'users:register']);
                } else if ($user->email_verified) {
                    $this->Flash->error(__('Email has already been verified'));
                    return $this->redirect(['_name' => 'users:login']);
                }

                $this->sendVerificationEmail($usersMailer, $user);
            }
        }

        $this->set(compact('emailForm'));
    }

    public function verifyEmail(UsersJwtService $usersJwt, string $token): Response
    {
        try {
            $userId = $usersJwt->extractUserId($token);
        } catch (ExpiredException) {
            $this->Flash->error(__('The verification link has expired'));
        } catch (Exception $e) {
            // Something seriously went wrong with the jwt.. maybe log this
        } finally {
            $this->Flash->error(__('Unable to verify email'));
            return $this->redirect(['_name' => 'users:resendVerificationEmail']);
        }

        $user = $this->Users->get($userId);
        $user->set('email_verified', true);
        
        if (!$this->Users->save($user)) {
            $this->Flash->error(__('Unable to update user account'));
            return $this->redirect(['_name' => 'users:resendVerificationEmail']);
        }

        $this->Flash->success(__('Email has been verified'));
        // TODO: Log user in and redirect to landing
    }

    public function resetPassword()
    {
        throw new NotImplementedException();
    }

    public function login()
    {
        // TODO: Template should have link 'Resend verification email' to resendVerificationEmail
        throw new NotImplementedException();
    }

    public function logout()
    {
        throw new NotImplementedException();
    }
}
