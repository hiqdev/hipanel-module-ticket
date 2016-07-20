<?php

use hipanel\widgets\FileRender;

/**
 * @var \hipanel\modules\ticket\models\Answer $model
 */

?>

<div class="attachment">
    <?php foreach ($model->files as $file) {
        echo FileRender::widget([
            'file' => $file,
            'lightboxLinkOptions' => [
                'data-lightbox' => 'answer-gal-' . $model->answer_id
            ]
        ]);
    }
    ?>
</div>
