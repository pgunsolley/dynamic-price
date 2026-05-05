<?php
/**
 * @var \App\Form\EmailForm $form
 */

$formId = 'password-reset-form';
?>

<div class="users form content">
    <?= $this->Form->create($form, ['id' => $formId]) ?>
    <fieldset>
        <legend><?= __('Please enter your email') ?></legend>
        <?= $this->Form->control('email') ?>
    </fieldset>
    <?= $this->element('RecaptchaV3.submit', [
        'text' => 'Send password reset email',
        'action' => 'request-password-reset',
    ]) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link(__('Go back'), ['_name' => 'users:login']) ?>
</div>
<?= $this->element('RecaptchaV3.recaptcha_v3', compact('formId')) ?>
