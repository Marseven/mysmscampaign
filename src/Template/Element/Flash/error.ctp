<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = $message;
}
?>
<div style="text-align: center;" class="alert alert-block alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <?= $message ?>
</div>

