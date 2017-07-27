<?php

use hipanel\widgets\FileRender;

/**
 * @var \yii\web\View
 * @var \hipanel\modules\ticket\models\Answer $model
 */
?>

<div class="attachment">
    <?php foreach ($model->files as $file) : ?>
        <div class="file-box">
            <div class="file">
                <div class="image">
                    <?= FileRender::widget([
                        'file' => $file,
                        'lightboxLinkOptions' => [
                            'data-lightbox' => 'answer-gal-' . $model->answer_id,
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
</div>
