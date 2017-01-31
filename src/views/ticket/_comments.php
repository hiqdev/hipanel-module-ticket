<?php
/**
 * HiPanel tickets module.
 *
 * @see      https://github.com/hiqdev/hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */
?>

<?php
/**
 * @var \yii\web\View
 * @var \hipanel\modules\ticket\models\Thread
 */
?>

<?php foreach ($model->answers as $answer_id => $answer) : ?>
    <?php if (!empty($answer->message)) : ?>
        <?= $this->render('_comment', ['model' => $model, 'answer_id' => $answer_id, 'answer' => $answer, 'client' => $client]) ?>
    <?php endif ?>
<?php endforeach ?>
