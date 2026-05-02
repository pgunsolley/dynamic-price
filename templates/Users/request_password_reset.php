<?php
/**
 * @var \App\Form\EmailForm $form
 */
?>
<div class="users form content">
    <?= $this->Form->create($form) ?>
    <fieldset>
        <legend><?= __('Please enter your email') ?></legend>
        <?= $this->Form->control('email') ?>
    </fieldset>
    <?= $this->Form->button(__('Send password reset email')) ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link(__('Go back'), ['_name' => 'users:login']) ?>
</div>
