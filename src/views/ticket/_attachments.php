<?php

use hipanel\widgets\FileRender;

/**
 * @var \yii\web\View
 * @var \hipanel\modules\ticket\models\Answer $model
 */
?>

<div class="attachment">
    <?php foreach ($model->files as $file) : ?>
        <?= FileRender::widget([
            'file' => $file,
            'lightboxLinkOptions' => [
                'data-lightbox' => 'answer-gal-' . $model->answer_id,
            ],
        ]); ?>
    <?php endforeach; ?>
</div>
