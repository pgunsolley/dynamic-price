<?php
/**
 * @var \App\Form\UserForm $form
 */
?>
<div class="users form content">
    <?= $this->Form->create($form) ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Login')) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Forgot your password', ['_name' => 'users:requestPasswordReset']) ?>
</div>
