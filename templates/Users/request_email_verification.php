<div class="users form content">
    <legend>Your email must be verified before you can continue</legend>
    <?= $this->Html->link(
        __('Send verification email'),
        [
            '_name' => 'users:requestEmailVerification',
            $this->getRequest()->getParam('token'),
            '?' => [
                'submit' => 1,
            ],
        ],
        [
            'class' => 'button',
        ]);
    ?>
</div>
