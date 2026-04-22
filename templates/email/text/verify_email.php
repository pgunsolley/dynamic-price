<?php

use Cake\Routing\Router;
?>

Go to <?= Router::url(['_name' => 'users:verifyEmail', $token]) ?> to verify your email and complete your registration.
