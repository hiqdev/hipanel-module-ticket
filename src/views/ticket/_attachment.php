<?php

use hipanel\widgets\FileRender;

?>

<div class="attachment">
    <?= FileRender::widget(['data' => $attachment, 'object_id' => $object_id, 'object_name' => $object_name, 'answer_id' => $answer_id]) ?>
</div>
