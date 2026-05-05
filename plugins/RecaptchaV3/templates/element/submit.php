<?php
/** 
 * @var string|null $text
 * @var string $recaptchaV3SiteKey
 * @var string $action
 */

if (!isset($recaptchaV3SiteKey)) {
    throw new InvalidArgumentException('recaptchaV3SiteKey is unset');
}

if (!isset($action)) {
    throw new InvalidArgumentException('action is unset');
}

echo $this->Form->button(__($text ?? 'Submit'), [
    'class' => 'g-recaptcha',
    'data-sitekey' => $recaptchaV3SiteKey,
    'data-callback' => 'onSubmit',
    'data-action' => $action,
]);
