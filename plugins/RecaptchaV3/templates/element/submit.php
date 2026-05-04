<?php
/** 
 * @var string $text
 * @var string $recaptchaV3SiteKey
 */
?>
<?= $this->Form->button(__($text), [
    'class' => 'g-recaptcha',
    'data-sitekey' => $recaptchaV3SiteKey,
    'data-callback' => 'onSubmit',
]) ?>
