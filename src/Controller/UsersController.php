<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\Enum\UserFormResult;
use App\Form\UserForm;
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
        $userForm = new UserForm();

        if ($this->request->is('post')) {
            $userForm->execute($this->request->getData());
            $email = $userForm->getData('email');
            
            match ($userForm->getResult()) {
                UserFormResult::Success             => $this->sendVerificationEmail($usersMailer, $userForm->getUser()),
                UserFormResult::ValidationError     => $this->Flash->error(__('Invalid email or password')),
                UserFormResult::UserNotFound        => $this->Flash->error(__('No account for {0}', $email)),
                UserFormResult::InvalidPassword     => $this->Flash->error(__('Invalid password for {0}', $email)),
                UserFormResult::Pending             => $this->Flash->error(__('Unable to process request')),
            };
        }

        $this->set(compact('userForm'));
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
