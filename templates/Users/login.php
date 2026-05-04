<?php
/**
 * @var \App\Form\UserForm $form
 */
?>
<div class="users form content">
    <?= $this->Form->create($form, ['id' => 'login-form']) ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->element('RecaptchaV3.submit', [
        'text' => 'login',
    ]) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Forgot your password', ['_name' => 'users:requestPasswordReset']) ?>
</div>
<?= $this->element('RecaptchaV3.recaptcha_v3', ['formId' => 'login-form']) ?>
