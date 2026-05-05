<?php
/**
 * @var \App\Model\Entity\User $user
 */

$formId = 'register-form';
?>

<div class="users form content">
    <?= $this->Form->create($user, ['id' => $formId]) ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->control('confirm_password', ['type' => 'password']) ?>
    </fieldset>
    <?= $this->element('RecaptchaV3.submit', [
        'text' => 'register',
        'action' => 'register',
    ]) ?>
    <?= $this->Form->end() ?>
    Already have an account? <?= $this->Html->link('Login', ['_name' => 'users:login']) ?>
</div>
<?= $this->element('RecaptchaV3.recaptcha_v3', compact('formId')) ?>
