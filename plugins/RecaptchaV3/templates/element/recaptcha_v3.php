<?php
/** @var string $formId */

if (!isset($formId)) {
    throw new InvalidArgumentException('formId is unset');
}
?>

<script>
    function onSubmit(token) {
        document.getElementById('<?= $formId ?>').submit();
    }
</script>
<script src="https://www.google.com/recaptcha/api.js"></script>
