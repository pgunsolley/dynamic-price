<?php
/**
 * @var \App\Form\UserForm $form
 */

$formId = 'login-form';
?>

<div class="users form content">
    <?= $this->Form->create($form, ['id' => $formId]) ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->element('RecaptchaV3.submit', [
        'text' => 'login',
        'action' => 'login',
    ]) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Forgot your password', ['_name' => 'users:requestPasswordReset']) ?>
</div>
<?= $this->element('RecaptchaV3.recaptcha_v3', compact('formId')) ?>
