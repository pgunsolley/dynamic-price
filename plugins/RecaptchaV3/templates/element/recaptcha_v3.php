<?php
    /** @var string $formId */
?>
<script>
    function onSubmit(token) {
        document.getElementById(<?= $formId ?>).submit();
    }
</script>
<script src="https://www.google.com/recaptcha/api.js"></script>
