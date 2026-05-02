<?php

/**
 * @var string $token
 */

use Cake\Routing\Router;
?>

Go to <?= Router::url(['_name' => 'users:handleEmailVerification', $token]) ?> to verify your email and complete your registration.

DO NOT SHARE THIS LINK. Treat it as a password to your account.
